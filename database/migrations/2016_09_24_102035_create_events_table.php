<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name', 255);
            $table->string('slug',255);
            $table->longText('description');
            $table->string('website', 255);
            $table->string('imageFilename',255)->default('');
            $table->string('postcode', 255);
            $table->date('startDate');
            $table->date('endDate');
            $table->date('closingDate');
            $table->string('payment_option', 255)->default('');
            $table->string('payment_account', 8)->nullable();
            $table->string('payment_sortcode', 8)->nullable();
            $table->string('payment_paypal_address', 255)->nullable();
            $table->string('status', 255)->default('unpublished');
            $table->integer('lateEntries')->default('0');
            $table->integer('registration')->default('0');
            $table->float('lateEntriesFee');
            $table->float('registrationFee');
            $table->string('currency')->default('GBP');
            $table->integer('featured')->default(0);
            $table->timestamps();
            //Relationship between organiser and user ID
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('no action'); //don't delete events if user deletes account
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
