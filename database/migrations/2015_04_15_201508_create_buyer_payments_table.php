<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyerPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('buyer_payments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('buyer_order_id')->unsigned();
            $table->integer('amount');
            $table->string('charge_id', 40);
            $table->string('card_id', 40);
            $table->string('card_object');
            $table->string('card_last4', 4);
            $table->string('card_brand', 20);
            $table->string('card_fingerprint', 16);
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
		Schema::drop('buyer_payments');
	}

}
