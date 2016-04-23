<?php

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
            $table->string('imageFilename',255);
            $table->string('postcode', 255);
            $table->date('startDate');
            $table->date('endDate');
            $table->date('closingDate');
            $table->string('paypal', 255);
            $table->string('status', 255)->default('unpublished');
            $table->integer('lateEntries');
            $table->integer('registration');
            $table->float('lateEntriesFee');
            $table->float('registrationFee');
            $table->integer('featured')->default(0);
            $table->timestamps();
            //Relationship between organiser and user ID
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); //delete events if user deletes account
        });

        //Note on the migrate::refresh foreign key issue. The migrations happen in the order
        //of the filenames (the dates). So I need to create them in the following order:
        //users, password_resets,events,competitions,details etc.

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
