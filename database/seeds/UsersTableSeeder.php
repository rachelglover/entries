<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
            'email' => 'rachelglover@gmail.com',
            'password' => bcrypt('rhl0verg'),
            'name' => 'Rachel Glover',
            'club' => 'Easingwold',
            'homeCountry' => 'IOM',
            'phone' => '07932914745',
        ]);

        /**
         * Create 50 random users
         */

        $firstnames = array('Alison', 'Brian', 'Chris', 'Dave', 'Elaine', 'Fred', 'Graham', 'Heather', 'Irene', 'Jackie', 'Kevin', 'Lorraine', 'Michael', 'Nigel', 'Ophelia', 'Pete', 'Quinn', 'Rebecca', 'Steve', 'Trevor', 'Ursula', 'Vernon', 'Rachel', 'Lina', 'Philip', 'Craig', 'Agnes', 'James');
        $lastnames = array('Smith', 'Jones', 'Killey', 'Qualtrough', 'Mylchreest', 'Taylor', 'Cooil', 'Cowley', 'Quilliam', 'Glover', 'Beck', 'Watson', 'Grey', 'Lannister', 'Stark', 'Bolton', 'Targaeryan');
        $clubs = array('IOMSC', 'Easingwold', 'Andover', 'Watten', 'Rugeley');
        $countries = array('IOM', 'ENG', 'SCO','WAL','NI','GUE','JER');
        for ($i = 0; $i <= 150; $i++ ) {
            $firstname = $firstnames[array_rand($firstnames,1)];
            $lastname = $lastnames[array_rand($lastnames,1)];
            $club = $clubs[array_rand($clubs,1)];
            $country = $countries[array_rand($countries,1)];
            $randomEmail = rand(0,1000);
            DB::table('users')->insert([
                'email' => $firstname . "." . $lastname . $randomEmail . "@foresightentries.com",
                'password' => "password",
                'name' => $firstname . " " . $lastname,
                'club' => $club,
                'homeCountry' => $country,
                'phone' => "07" . rand(100000000,999999999)
            ]);
        }
    }
}
