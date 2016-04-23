<?php

use Illuminate\Database\Seeder;

class ExtrasOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extra_orders')->insert([
        	'extra_id' => 1,
            'event_id' => 1,
            'user_id' => 1,
            'multiple' => 3,
            'infoRequired' => 'No info required',
        ]);
        DB::table('extra_orders')->insert([
        	'extra_id' => 2,
        	'event_id' => 1,
        	'user_id' => 1,
        	'multiple' => 1,
        	'infoRequired' => "The dirty dozen",
        ]);
        DB::table('extra_orders')->insert([
        	'extra_id' => 3,
        	'event_id' => 1,
        	'user_id' => 1,
        	'multiple' => 1,
        	'infoRequired' => 'No info required',
        ]);
    }
}
