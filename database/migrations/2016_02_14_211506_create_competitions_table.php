<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('name', 255);
            $table->string('description', 255);
            $table->float('fee');
            $table->timestamps();
            //Relationship between competition and event id
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
        Schema::dropIfExists('competitions');

    }
}
