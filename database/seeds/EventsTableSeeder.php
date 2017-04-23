<?php

use App\Detail;
use App\Entry;
use App\Event;
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create 10 events
         */
        $featuredCount = 0; //no more than 4
        for ($i=0; $i<10; $i++) {
            if ($featuredCount < 4) {
                $featured = rand(0,1); 
                if ($featured == 1) {
                    $featuredCount += 1;
                }
            } else {
                $featured = 0;
            }

            $year = 2017;
            $month = rand(4,12);
            $startDate = rand(8,28); #8 is imp because of closingd ate
            $endDate = $startDate + 2;
            $closingDate = $startDate - 7;
            $statuses = array('unpublished','published', 'published','published');
            $status = $statuses[array_rand($statuses,1)];

            $late = array_rand(array(0,1),1);
            $lateFee = 0;
            if ($late == 1) {
                $lateFee = rand(0,10);
            }
            $reg = array_rand(array(0,1),1);
            $regFee = 0;
            if ($reg == 1) {
                $regFee = rand(0,10);
            }
            $paymentOptions = array('bank', 'paypal');
            $paymentOption = $paymentOptions[array_rand($paymentOptions)];
            $bankAccount = null;
            $sortCode = null;
            $paypalAddress = null;
            if ($paymentOption == 'bank') {
                $bankAccount = '12345678';
                $sortCode = '40-47-31';
            }
            if ($paymentOption == 'paypal') {
                $paypalAddress = 'rachelglover@gmail.com';
            }
            $event_id = DB::table('events')->insertGetId([
                'user_id' => 1,
                'name' => 'Awesome event ' . $i,
                'slug' => Str::slug('Awesome event ' . $i),
                'description' => 'This is the event description.',
                'postcode' => 'YO24 4QP',
                'startDate' => Carbon\Carbon::createFromDate($year, $month, $startDate,'Europe/London'),
                'endDate' => Carbon\Carbon::createFromDate($year, $month, $endDate, 'Europe/London'),
                'closingDate' => Carbon\Carbon::createFromDate($year, $month, $closingDate, 'Europe/London'),
                'payment_option' => $paymentOption,
                'payment_account' => $bankAccount,
                'payment_sortcode' => $sortCode,
                'payment_paypal_address' => $paypalAddress,
                'website' => 'www.google.com',
                'status' => $status,
                'lateEntries' => $late,
                'lateEntriesFee' => $lateFee,
                'registration' => $reg,
                'registrationFee' => $regFee,
                'featured' => $featured,
                'currency' => 'GBP',
                'imageFilename' => $i . ".jpg"
            ]);

            //Create between 5-15 competitions
            for ($j=0; $j<rand(5,15);$j++) {
                $comp_id = DB::table('competitions')->insertGetId([
                    'event_id' => $event_id,
                    'name' => 'Competition ' . $j,
                    'description' => 'This is the competition description.',
                    'fee' => rand(5,25),
                ]);

                //Create 1-3 details
                $numDetails = rand(1,3);
                for ($k = 0; $k<$numDetails; $k++) {
                    $hour = rand(0,23);
                    $minutes = array('00','15','30','45');
                    $minute = $minutes[array_rand($minutes,1)];
                    $max = rand(5,25);
                    $detail_id = DB::table('details')->insertGetId([
                        'competition_id' => $comp_id,
                        'name' => 'Qualification ' . $k,
                        'max' => $max,
                        'dateTime' => Carbon\Carbon::create($year, $month, $startDate, $hour, $minute, '00', 'Europe/London'),
                    ]);
                }
            }
            //we've created competitions and details for this event. now do some entries
            $event = Event::findOrFail($event_id);
            foreach ($event->competitions()->get() as $competition) {
                $users = User::all()->keyBy('id');
                $users->forget(1);
                $details = $competition->details()->get();
                $detail = $details->random();
                for ($e=0; $e < rand(1,20); $e++) {
                    $user = $users->random();
                    DB::table('entries')->insert([
                        'user_id' => $user->id,
                        'event_id' => $event_id,
                        'competition_id' => $competition->id,
                        'detail_id' => $detail->id,
                        'transaction_id' => null,
                        'name' => $user->name,
                        'paymentStatus' => 'paid',
                        'discounts_applied' => '',
                    ]);
                    $users->forget($user->id);
                    $detail = $details->random();
                }
            }
        }
    }
}