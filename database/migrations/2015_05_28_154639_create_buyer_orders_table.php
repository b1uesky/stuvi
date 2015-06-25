<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyerOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('buyer_orders', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('buyer_id')->unsigned();
            $table->boolean('cancelled')->default(false);
            $table->integer('courier_id')->unsigned()->nullable();
            $table->timestamp('time_delivered')->nullable();
            $table->integer('shipping_address_id')->unsigned();
            $table->timestamps();

            $table->foreign('shipping_address_id')->references('id')->on('addresses');
            $table->foreign('buyer_id')->references('id')->on('users');
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
		Schema::drop('buyer_orders');
	}

}
