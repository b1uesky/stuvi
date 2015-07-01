<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripeTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_transfers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('seller_order_id')->unsigned();
            $table->string('transfer_id');
            $table->string('object');
            $table->integer('amount');
            $table->string('currency');
            $table->string('status');
            $table->string('type');
            $table->string('balance_transaction');
            $table->string('destination');
            $table->string('destination_payment');
            $table->string('source_transaction');
            $table->string('application_fee');

            $table->timestamps();

            $table->foreign('seller_order_id')->references('id')->on('seller_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stripe_transfers');
    }
}
