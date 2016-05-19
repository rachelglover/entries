<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Event;
use App\Entry;
use App\Detail;
use App\Competition;
use App\Answer;
use App\ExtraOrder;
use App\Extra;
use App\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        //dd($data);
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
                $entryData['discounts_applied'] = $data['discounts_applied'];
                //Now insert the data
                //dd($entryData);
                Entry::create($entryData);
            }
        }
        
        //2. Insert question answers in to answers table
        if (key_exists('questions',$data)) {
            foreach ($data['questions'] as $question_id => $question_answer) {
                $answerData = array();
                $answerData['question_id'] = $question_id;
                $answerData['competitor_id'] = $user->id;
                $answerData['event_id'] = $data['event_id'];
                if ($question_answer) {
                    $answerData['answer'] = $question_answer;
                } //if "" then default will be "No answer given" as per schema.

                //create the answer
                //dd($answerData);
                Answer::create($answerData);
            }
        }

        //3. Insert any extras that have been ordered into orders table
        //dd($data['extras']);
        if (key_exists('extras',$data)) {
            foreach ($data['extras'] as $extra_id => $extraOrder) {
                $orderData = array();
                $orderData['extra_id'] = $extra_id;
                $orderData['event_id'] = $data['event_id'];
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
            //EVENT ORGANISER? Not right now. I'll do it manually at the closing date. 

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

        //Format the extras for display in the confirmation form
        $extras = array();
        if (key_exists('extras',$data)) {
            foreach ($data['extras'] as $extra_id => $extraOrder) {
                $multiple = 1;
                $infoRequired = NULL;
                if (is_string($extraOrder) == False) {
                    //This is an extra order with an array of info
                    if (array_key_exists('multiple', $extraOrder)) {
                        $multiple = $extraOrder['multiple'];
                    }
                    if (array_key_exists('infoRequired', $extraOrder)) {
                        $infoRequired = $extraOrder['infoRequired'];
                    }
                }
                $extra = Extra::findOrFail($extra_id);
                $thisExtraTotal = $extra->cost * $multiple;
                $extraSubTotal += $thisExtraTotal;
                $extras[$extra_id] = array('id' => $extra_id, 'multiple' => $multiple, 'infoRequired' => $infoRequired, 'extra' => $extra, 'thisExtraCost' => $thisExtraTotal);
            }
        }

        //Format the discounts so that the fixed and percentage discounts
        //can be applied separately, fixed first.
        $discounts = array();
        $fixedDiscounts = array();
        $percentageDiscounts = array();
        $discounts_applied = "";
        if (key_exists('discounts',$data)) {
            foreach ($data['discounts'] as $discount_id => $discountApply) {
                if ($discountApply == 1) {
                    $discount = Discount::findOrFail($discount_id);
                    $discounts[] = $discount;
                    $discounts_applied = $discounts_applied . $discount_id . "-";
                }
            }
            $discounts = collect($discounts);
            $fixedDiscounts = $discounts->where('type','fixed');
            $percentageDiscounts = $discounts->where('type', 'percentage');
        }
        //total (just competitions and extras)
        $compExtraSubtotal = $compSubTotal + $extraSubTotal;

        //Apply any discounts to the compextrasubtotal & registration fee
        //fixed fees first, then %.
        $discountedSubtotal = $compExtraSubtotal;
        $discountedRegistrationFee = $event->registrationFee;
        $percentageDiscountValues = array();
        foreach ($fixedDiscounts as $fd) {
            $discountedSubtotal = $discountedSubtotal - $fd->value;
        }
        foreach ($percentageDiscounts as $pd) {
            $percentage = $pd->value / 100;
            $discount = $discountedSubtotal * $percentage;
            $percentageDiscountValues[$pd->id] = $discount;
            $discountedSubtotal = $discount;
            $discountedRegistrationFee = $discountedRegistrationFee * $percentage;
        }

        //Charge a late entry fee? //if it's past the closing date
        $lateEntryFee = 0;
        if (Carbon::now()->gt($event->closingDate)) {
            $lateEntryFee = $event->lateEntriesFee;
        }

        $finalsubtotal = $discountedSubtotal + $discountedRegistrationFee + $lateEntryFee + 3.50;

        //paypal fees (3.4% + 20p)
        $paypalFees = ($finalsubtotal * 0.034) + 0.2;

        $feesTotal = $discountedRegistrationFee + $lateEntryFee + 3.50 + $paypalFees;

        $grandTotal = $finalsubtotal + $paypalFees;

        $format = "%4.2f";
        $variables = array(
            'entrydata' => $data,
            'event' => $event,
            'user' => $user,
            'entries' => $entries,
            'extras' => $extras,
            'fixedDiscounts' => $fixedDiscounts,
            'percentageDiscounts' => $percentageDiscounts,
            'percentageDiscountValues' => $percentageDiscountValues,
            'compSubTotal' => sprintf($format,$compSubTotal),
            'extraSubTotal' => sprintf($format,$extraSubTotal),
            'compExtraSubtotal' => sprintf($format,$compExtraSubtotal),
            'discountedSubtotal' => sprintf($format,$discountedSubtotal),
            'discountedRegistrationFee' => sprintf($format,$discountedRegistrationFee),
            'lateEntryFee' => sprintf($format,$lateEntryFee),
            'paypalFees' => sprintf($format,$paypalFees),
            'feesTotal' => sprintf($format, $feesTotal),
            'grandTotal' => sprintf($format, $grandTotal),
            'discounts_applied' => $discounts_applied,
        );
        //dd($variables);
        return view('events.entryconfirm')->with($variables);
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
        //dd($data);
        //payment approved
        $user = Auth::user();
        $event = Event::findOrFail($event_id);
        if ($data['state'] === 'approved') {
            $transaction = array(
                'event_id' => $event_id,
                'user_id' => $user->id,
                'transaction_type' => 'competitor_payment',
                'paypal_sale_id' => $data['transactions'][0]['related_resources'][0]['sale']['id'],
                'payment_method' => $data['payer']['payment_method'],
                'status' => $data['state'],
                'total' => $data['transactions'][0]['amount']['total'],
                'currency' => $data['transactions'][0]['amount']['currency'],
                'transaction_fee' => $data['transactions'][0]['related_resources'][0]['sale']['transaction_fee']['value'],
            );
            $savedTransaction = Transaction::create($transaction);
            //Change all the entries to paid
            $entries = $user->eventEntries($event_id);
            foreach ($entries as $entry) {
                $entry->paymentStatus = 'paid';
                $entry->transaction_id = $savedTransaction->id;
                $entry->save();
            }

            \Flash::success('Thank you, your payment was successful and your current entries below.');
            return redirect(action('PagesController@userEntries'));
        } elseif ($data['state'] === 'failed') {
            //Delete the user entry and leave message
            $entries_to_delete = $user->eventEntries($event_id);
            foreach ($entries_to_delete as $entry) {
                $entry->delete();
            }
            \Flash::error('Unfortunately your payment failed. Your entry to this event has *not* been completed. If you still want to proceed, please enter again.');
            return redirect(action('EventsController@show', $event->slug));
        }
    }

    /**
     * If the entry is cancelled by the user at paypal login page.
     */
    public function postPaypalCancelled( Request $request, $event_id) {
        $user = Auth::user();
        $entries_to_delete = $user->eventEntries($event_id);
        foreach ($entries_to_delete as $entry) {
            $entry->delete();
        }
        \Flash::info("We're sorry you changed your mind and cancelled your payment (your entry to this event was *not* completed). We've brought you back to the event entry page in case you still want to enter.");
        $event = Event::findOrFail($event_id);
        return redirect(action('EventsController@show', $event->slug));
    }

    /**
     * Change the detail for a competition (after the user has entered the event)
     */
    public function changeDetail(Request $request, $entry_id) {
        $data = $request->all();
        $entry = Entry::findOrFail($entry_id);
        $entry['detail_id'] = $data['newDetail'];
        $entry->save();
        $detail = Detail::findOrFail($data['newDetail']);
        \Flash::success("No problem! You're detail has been changed to " . $detail->dateTime->toDateTimeString());
        return redirect(action('PagesController@userEntries'));
    }
    
    /**
     * Competitor cancels one competition entry, but not their entire entry to all competitions
     */
    public function cancelCompetition(Request $request, $entry_id) {
        $entry = Entry::findOrFail($entry_id);
        $entry['paymentStatus'] = 'pending_cancellation';
        $entry->save();
        $competition = $entry->competition()->first();
        \Flash::success("Your entry to " . $competition->name . " was cancelled and you will be refunded within 48 hours.");
        return redirect(action('PagesController@userEntries'));
    }

    /**
     * Competitor cancels all entries for an event
     */
    public function cancelEntireEntry(Request $request, $event_id) {
        $user = Auth::user();
        $entries = $user->entries()->where('event_id','=',$event_id)->get();
        foreach ($entries as $entry) {
            $entry['paymentStatus'] = 'pending_cancellation';
            $entry->save();
        }
        $event = Event::find($event_id);
        \Flash::success("Your entries to '" . $event->name . "' have been cancelled and you will be refunded within 48 hours.");
        return redirect(action('PagesController@userEntries'));
    }
}
