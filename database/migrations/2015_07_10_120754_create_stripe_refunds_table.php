<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripeRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stripe_refunds');
    }
}
