<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkBuyerPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('buyer_payments', function(Blueprint $table)
        {
            $table->foreign('buyer_order_id')->references('id')->on('buyer_orders');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('buyer_payments', function(Blueprint $table)
        {
            $table->dropForeign('buyer_payments_buyer_order_id_foreign');
        });
	}

}
