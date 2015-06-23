<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seller_orders', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->boolean('cancelled')->default(false);
            $table->timestamp('scheduled_pickup_time')->nullable();
            $table->timestamp('pickup_time')->nullable();
            $table->integer('courier_id')->unsigned();
            $table->integer('buyer_order_id')->unsigned();
            $table->timestamps();

            $table->foreign('courier_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('seller_orders');
	}

}
