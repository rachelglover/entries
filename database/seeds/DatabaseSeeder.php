<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(EventTagTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(ExtrasTableSeeder::class);
        $this->call(ExtrasOrdersTableSeeder::class);
        $this->call(DiscountsTableSeeder::class);
    }
}
