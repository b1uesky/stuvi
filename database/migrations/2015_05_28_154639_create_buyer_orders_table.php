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
            $table->timestamp('deliver_time')->nullable();
            $table->timestamps();
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
