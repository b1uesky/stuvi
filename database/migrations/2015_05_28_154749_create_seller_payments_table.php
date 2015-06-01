<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('seller_payments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('stripe_token');
            $table->string('stripe_token_type');
            $table->string('stripe_email');
            $table->integer('stripe_amount');
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
		Schema::drop('seller_payments');
	}

}
