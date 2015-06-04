<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        /*
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->boolean('cancelled')->default(false);
            $table->integer('seller_payment_id')->unsigned()->nullable();
            $table->string('scheduled_pickup_time')->nullable();
            $table->string('pickup_time')->nullable();
            $table->timestamps();
		});
        */
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		///Schema::order('orders');
	}

}
