<?php

namespace App\Http\Controllers;

use App\Event;
use App\Entry;
use App\Detail;
use App\Competition;
use App\Answer;
use App\ExtraOrder;
use App\Extra;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Omnipay\Omnipay;

class EntryController extends Controller
{
    protected $gateway;

    /**
     * set up the gateway
     */
    public function __construct() {
        $this->middleware('auth');
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->initialize(array(
            'clientId' => 'AfxkjYnYtKvmw7LWILpaXLt5I6r8pjawenkfJHe7WwMjsgD6X3CpC0DYG73V9NlpKUXtYH2jhV7---tF',
            'secret' => 'EK732ktMXGGkqHUmY5SdDgs5DZNbnWEKqjGWE2uiwZvBTtom-9Bwdy3seMY1-t2njQwsQz84ctxO7XkG',
            'testMode' => true));
    }

    /**
     * Show entry form for an event
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id) {
        $event = Event::findOrFail($id);
        $user = Auth::user();
        return view('events.entry')->with(['event' => $event, 'user' => $user]);
    }


    /**
     * Initially store the entry and send the user to Paypal for payment
     * @param Request $request
     */
    public function store(Request $request) {
        // Get the data from the request
        $data = $request->all();
        dd($data);
        $user = Auth::user();

        //1. Insert each competition entry into the database with 'unpaid' status
        foreach ($data['competitions'] as $competition_id => $detail_id) {
            if ($detail_id != "noEntry") {
                $entryData = array();
                $entryData['user_id'] = $user->id;
                $entryData['event_id'] = $data['event_id'];
                $entryData['competition_id'] = $competition_id;
                $entryData['detail_id'] = $detail_id;
                $entryData['user_lastname'] = $user->lastname;
                $entryData['paymentStatus'] = 'unpaid';
                //Now insert the data
                //dd($entryData);
                Entry::create($entryData);
            }
        }
        
        //2. Insert question answers in to answers table
        foreach ($data['questions'] as $question_id => $question_answer) {
            $answerData = array();
            $answerData['question'] = $question_id;
            $answerData['competitor'] = $user->id;
            $answerData['event'] = $data['event_id'];
            if ($question_answer) {
                $answerData['answer'] = $question_answer;
            } //if "" then default will be "No answer given" as per schema.
            
            //create the answer
            //dd($answerData);
            Answer::create($answerData);
        }

        //3. Insert any extras that have been ordered into orders table
        //dd($data['extras']);
        foreach ($data['extras'] as $extra_id => $extraOrder) {
            $orderData = array();
            $orderData['extra_id'] = $extra_id;
            $orderData['user_id'] = $user->id;
            if ($extraOrder != "order") {
                //This is an extra order with an array of info
                if(array_key_exists('multiple',$extraOrder)) {
                    $orderData['multiple'] = $extraOrder['multiple'];
                }
                if(array_key_exists('infoRequired',$extraOrder)) {
                    $orderData['infoRequired'] = $extraOrder['infoRequired'];
                }
            }
            //create the extra order
            ExtraOrder::create($orderData);
        }

        //4. Send off the payment request to paypal (success=success, fail=delete above)
        //send over the event id, then later grab all the entries for this
        // user from the database and change the status or delete as appropriate after paypal payment.
        $event = Event::findOrFail($data['event_id']);
        try {
            $transactionDescription = "Entry fees for " . $event->name . ": £" . $data['total'];
            $transaction = $this->gateway->purchase(
                array(
                    'amount' => $data['total'],
                    'currency' => 'GBP',
                    'description' => $transactionDescription,
                    'returnUrl' => 'http://foresightentries.app/entry/paid/' . $event->id,
                    'cancelUrl' => 'http://foresightentries.app/entry/cancelled/' . $event->id,                )
            );

            $transaction->setItems(array(
                array('name' => "Entry fees ($event->name)", 'quantity' => '1', 'price' => $data['total'])
            ));

            //SO THE BIG QUESTION HERE IS HOW DO I SEND THE PAYMENTS IN BITS TO ME AND 
            //EVENT ORGANISER?

            $response = $transaction->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                echo $response->getMessage();
                //do something here, presumably redirect to an error page. 
            }
        } catch (\Exception $e) {
            echo "Exception caught while attempting authorize.\n";
            echo "Exception type == " . get_class($e) . "\n";
            echo "Message == " . $e->getMessage() . "\n";
        }
    }

    /**
     * Formats a messy form and presents the user with a confirmation page (form) before
     * proceeding to payment.
     */
    public function confirmEntry( Request $request ) {
        // returns a confirm view which then sends the user to the store function above.
        $data = $request->all();
        $user = Auth::user();
        $event = Event::findOrFail($data['event_id']);
        $compSubTotal = 0;
        $extraSubTotal = 0;
        $total = 0;

        //Format the competitions for display in the confirmation form
        $entries = array();
        //$competitions[$id] = array('detail' => $detail, 'competition' => $competition)
        foreach ($data['competitions'] as $competition_id => $detail_id) {
            if ($detail_id != "noEntry") {
                $competition = Competition::findOrFail($competition_id);
                $detail = Detail::findOrFail($detail_id);
                $entries[$competition_id] = array('competition' => $competition, 'detail' => $detail);
                $compSubTotal += $competition->fee; 
            }
        }

        $extras = array();
        foreach ($data['extras'] as $extra_id => $extraOrder) {
            $multiple = 1;
            $infoRequired = NULL;
            if (is_string($extraOrder) == False) {
                //This is an extra order with an array of info
                if(array_key_exists('multiple',$extraOrder)) {
                    $multiple = $extraOrder['multiple'];
                }
                if(array_key_exists('infoRequired',$extraOrder)) {
                    $infoRequired = $extraOrder['infoRequired'];
                }
            }
            $extra = Extra::findOrFail($extra_id);
            $thisExtraTotal = $extra->cost * $multiple;
            $extraSubTotal += $thisExtraTotal;
            $extras[$extra_id] = array('multiple' => $multiple, 'infoRequired' => $infoRequired, 'extra' => $extra, 'thisExtraCost' => $thisExtraTotal);
        }

        //Charge a late entry fee? //if it's past the closing date
        $lateEntryFee = 0;
        if (Carbon::now()->gt($event->closingDate)) {
            $lateEntryFee = $event->lateEntriesFee;
        } 

        //Registration fees
        $regFeesTotal = $event->registrationFee + 3.50;

        //total
        $total = $compSubTotal + $extraSubTotal + $regFeesTotal + $lateEntryFee;

        //paypal fees (3.4% + 20p)
        $paypalFees = ($total * 0.034) + 0.2;

        //Grand total (including paypal fees);
        $grandTotal = $total + $paypalFees;

        $format = "%4.2f";
        return view('events.entryconfirm')->with(['entrydata' => $data, 'event' => $event, 'user' => $user, 'entries' => $entries, 'extras' => $extras, 'compSubTotal' => sprintf($format,$compSubTotal), 'extraSubTotal' => sprintf($format,$extraSubTotal), 'paypalFees' => sprintf($format,$paypalFees), 'lateEntriesFee' => sprintf($format,$lateEntryFee), 'grandTotal' => sprintf($format, $grandTotal), 'registrationFees' => sprintf($format, $regFeesTotal)]);
    }

    /**
     * User is returned successfully from Paypal after paying their fees. 
     */
    public function postPaypalComplete( Request $request, $event_id) {
        //Complete the transaction
        $complete = $this->gateway->completePurchase(
            array(
                'transactionReference' => $request->paymentId,
                'payerId' => $request->PayerID,
            )
        );
        $response = $complete->send();
        $data = $response->getData();

        //payment approved
        $user = Auth::user();
        if ($data['state'] === 'approved') {
            //Change entry status to 'paid' and then redirect. 
            $entry = Entry::find()->where('competitor','=',$user->id)->where('event','=',$event_id)->get();

            \Flash::success('Thank you, your payment was successful and you will find all of your current entries below.');
        }
    }

    
}
