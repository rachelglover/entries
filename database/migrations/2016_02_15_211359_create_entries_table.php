<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('competition_id')->unsigned();
            $table->integer('detail_id')->unsigned();
            $table->integer('transaction_id')->default(null)->unsigned()->nullable();
            $table->string('paymentStatus', 255);
            $table->string('user_lastname',255);
            $table->timestamps();
            //Relationship between entry and event_id
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('no action');
            //Relationship between entry and detail_id
            $table->foreign('detail_id')
                ->references('id')
                ->on('details')
                ->onDelete('no action');
            //Relationship between entry and user_id
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('no action');
            //Relationship between entry and competition
            $table->foreign('competition_id')
                ->references('id')
                ->on('competitions')
                ->onDelete('no action');
            //Relationship between entry and transaction
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');

    }
}
