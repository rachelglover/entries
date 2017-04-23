<?php

use Illuminate\Database\Seeder;

class EventTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //currently 11 tags
        for ($i = 1; $i<10; $i++) {
            for ($j = 1; $j<rand(1,5); $j++) {
                DB::table('event_tag')->insert([
                    'event_id' => $i,
                    'tag_id' => rand(1,11),
                ]);
            }
        }
    }
}
