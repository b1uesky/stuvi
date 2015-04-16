<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('orders', function(Blueprint $table)
        {
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreign('buyer_payment_id')->references('id')->on('buyer_payments');
            //$table->foreign('seller_payment_id')->references('id')->on('seller_payments');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('orders', function(Blueprint $table)
        {
            $table->dropForeign('orders_product_id_foreign');
            $table->dropForeign('orders_buyer_id_foreign');
            $table->dropForeign('orders_buyer_payment_id_foreign');
            //$table->dropForeign('orders_seller_payment_id_foreign');
        });
	}

}
