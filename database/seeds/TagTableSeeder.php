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
            'name' => 'Smallbore',
        ]);
        DB::table('tags')->insert([
            'name' => 'Fullbore',
        ]);
        DB::table('tags')->insert([
            'name' => 'Air',
        ]);
        DB::table('tags')->insert([
            'name' => 'Pistol',
        ]);
        DB::table('tags')->insert([
            'name' => 'Rifle',
        ]);
        DB::table('tags')->insert([
            'name' => 'ISSF',
        ]);
        DB::table('tags')->insert([
            'name' => 'NSRA',
        ]);
        DB::table('tags')->insert([
           'name' => 'International'
        ]);
        DB::table('tags')->insert([
            'name' => 'National',
        ]);
        DB::table('tags')->insert([
            'name' => 'County',
        ]);
        DB::table('tags')->insert([
            'name' => 'Club',
        ]);
    }
}
