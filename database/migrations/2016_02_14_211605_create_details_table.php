<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('competition_id')->unsigned();
            $table->string('name');
            $table->integer('max');
            $table->datetime('dateTime');
            $table->timestamps();
            //Relationship between detail and competition
            $table->foreign('competition_id')
                ->references('id')
                ->on('competitions')
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
        Schema::dropIfExists('details');
    }
}
