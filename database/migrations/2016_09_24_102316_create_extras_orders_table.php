<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtrasOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_orders', function (Blueprint $table) {
            $table->increments('id');$table->integer('extra_id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('multiple')->default(0);
            $table->string('infoRequired',255)->default("No info required");
            $table->timestamps();
            //Relationship between extra order and event ID
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade'); //don't delete events if user deletes account
            //Relationship between extra order and extra ID
            $table->foreign('extra_id')
                ->references('id')
                ->on('extras')
                ->onDelete('cascade');
            //Relationship between extra order and user ID
            $table->foreign('user_id')
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
        Schema::dropIfExists('extra_orders');
    }
}
