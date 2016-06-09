<?php

use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name' => 'NSRA',
        ]);
        DB::table('tags')->insert([
            'name' => 'ISSF',
        ]);
        DB::table('tags')->insert([
            'name' => 'Prone',
        ]);
        DB::table('tags')->insert([
            'name' => '3P',
        ]);
        DB::table('tags')->insert([
            'name' => 'Rifle',
        ]);
        DB::table('tags')->insert([
            'name' => 'Air Rifle',
        ]);
        DB::table('tags')->insert([
            'name' => 'Pistol',
        ]);
        DB::table('tags')->insert([
            'name' => 'Air Pistol',
        ]);
        DB::table('tags')->insert([
            'name' => '50m',
        ]);
        DB::table('tags')->insert([
            'name' => '10m',
        ]);
        DB::table('tags')->insert([
            'name' => '25m',
        ]);
        DB::table('tags')->insert([
            'name' => '300m',
        ]);
        DB::table('tags')->insert([
            'name' => '25yd',
        ]);
        DB::table('tags')->insert([
            'name' => '15yd',
        ]);
        DB::table('tags')->insert([
            'name' => '20yd',
        ]);
        DB::table('tags')->insert([
            'name' => '100yd',
        ]);
        DB::table('tags')->insert([
            'name' => 'Dewar',
        ]);
        DB::table('tags')->insert([
            'name' => 'Double Dewar',
        ]);
        DB::table('tags')->insert([
            'name' => 'English Match',
        ]);
        DB::table('tags')->insert([
            'name' => 'Indoor',
        ]);
        DB::table('tags')->insert([
            'name' => 'Outdoor',
        ]);
        DB::table('tags')->insert([
            'name' => 'Electronic targets',
        ]);

    }
}
