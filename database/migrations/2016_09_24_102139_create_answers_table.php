<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->integer('competitor_id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->string('answer', 255)->default('No answer given');
            $table->timestamps();
            //Relationship between competition and event id
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');
            //Relationship between competition and event id
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');
            //Relationship between competition and event id
            $table->foreign('competitor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
