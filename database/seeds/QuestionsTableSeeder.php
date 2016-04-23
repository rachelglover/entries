<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'event_id' => 1,
            'question' => 'What is your membership number?',
            'answerType' => 'number',
            'listItems' => '',
        ]);
        DB::table('questions')->insert([
        	'event_id' => 1,
        	'question' => 'Are you a junior?',
        	'answerType' => 'boolean',
        	'listItems' => '',
    	]);
    	DB::table('questions')->insert([
    		'event_id' => 1,
    		'question' => 'What is your national classification?',
    		'answerType' => 'list',
    		'listItems' => 'X Class, A Class, B Class, C Class, D Class'
		]);
		DB::table('questions')->insert([
			'event_id' => 1,
			'question' => 'What is your date of birth?',
			'answerType' => 'date',
			'listItems' => '',
		]);
    }
}
