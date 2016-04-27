<?php

use Illuminate\Database\Seeder;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
            'event_id' => 1,
            'type' => 'percentage',
            'value' => 50,
            'for' => 'Juniors',
            'info' => 'Juniors must be under 21 on 31st January 2016',
        ]);
        DB::table('discounts')->insert([
            'event_id' => 1,
            'type' => 'fixed',
            'value' => 5,
            'for' => 'Members',
            'info' => '',
        ]);
    }
}
