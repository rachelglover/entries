<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('transaction_type'); // 'competitor_payment','organiser_transfer','competitor_refund'
            $table->string('cart');
            $table->string('payment_method');
            $table->string('status');
            $table->float('total');
            $table->string('currency');
            $table->float('transaction_fee');
            $table->timestamps();
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('no action'); //if event is deleted keep transactions
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('no action'); //if user is deleted keep transactions
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
