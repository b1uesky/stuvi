<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkSellerOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('seller_orders', function(Blueprint $table)
        {
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('seller_payment_id')->references('id')->on('seller_payments');
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
		Schema::table('seller_orders', function(Blueprint $table)
        {
            $table->dropForeign('seller_orders_product_id_foreign');
            $table->dropForeign('seller_orders_seller_payment_id_foreign');
            $table->dropForeign('seller_orders_buyer_order_id_foreign');
        });
	}

}
