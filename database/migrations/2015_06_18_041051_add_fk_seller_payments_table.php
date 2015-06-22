<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkSellerPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('seller_payments', function(Blueprint $table)
        {
            $table->foreign('seller_order_id')->references('id')->on('seller_orders');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('seller_payments', function(Blueprint $table)
        {
            $table->dropForeign('seller_payments_seller_order_id_foreign');
        });
	}

}
