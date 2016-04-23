<?php

use Illuminate\Database\Seeder;

class ExtrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extras')->insert([
            'event_id' => 1,
            'name' => 'Presentation Dinner',
            'cost' => '20.00',
            'multiples' => 1,
            'infoRequired' => 0,
            'infoRequiredLabel' => ''
        ]);
        DB::table('extras')->insert([
    		'event_id' => 1,
    		'name' => 'Team of 2',
    		'cost' => '2.50',
    		'multiples' => 0,
    		'infoRequired' => 1,
    		'infoRequiredLabel' => 'Team name and partner\'s name:',
    	]);
    	DB::table('extras')->insert([
    		'event_id' => 1,
    		'name' => 'Grand aggregate',
    		'cost' => '5.00',
    		'multiples' => 0,
    		'infoRequired' => 0,
    		'infoRequiredLabel' => '',
		]);
    }
}
