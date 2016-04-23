<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('question', 255);
            $table->string('answerType', 255);
            $table->string('listItems', 255);
            $table->timestamps();
            //Relationship between question and event id
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade'); //delete competition if user deletes event
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
