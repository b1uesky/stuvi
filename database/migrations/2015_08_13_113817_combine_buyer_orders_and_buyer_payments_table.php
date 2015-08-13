<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CombineBuyerOrdersAndBuyerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('buyer_payments');

        Schema::table('buyer_orders', function(Blueprint $table) {
            $table->integer('amount');
            $table->string('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyer_orders', function(Blueprint $table) {
            $table->dropColumn('amount');
            $table->dropColumn('payment_id');
        });

        Schema::create('buyer_payments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('buyer_order_id')->unsigned();
            $table->string('payment_id');
            $table->integer('amount');
            $table->string('card_last4', 4);
            $table->string('card_brand', 20);
            $table->timestamps();

            $table->foreign('buyer_order_id')->references('id')->on('buyer_orders');
        });
    }
}
