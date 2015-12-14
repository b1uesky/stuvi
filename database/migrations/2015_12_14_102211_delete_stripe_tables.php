<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteStripeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('stripe_authorization_credentials');
        Schema::drop('stripe_refunds');
        Schema::drop('stripe_transfers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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

        Schema::create('stripe_refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buyer_order_id')   ->unsigned();
            $table->string('refund_id');
            $table->integer('amount')       ->unsigned();
            $table->integer('operator_id')  ->unsigned();
            $table->timestamps();

            $table->foreign('buyer_order_id')   ->references('id')  ->on('buyer_orders');
            $table->foreign('operator_id')      ->references('id')  ->on('users');
        });

        Schema::create('stripe_authorization_credentials', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('access_token');
            $table->string('refresh_token');
            $table->string('token_type');
            $table->string('stripe_publishable_key');
            $table->string('stripe_user_id');
            $table->string('scope');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
