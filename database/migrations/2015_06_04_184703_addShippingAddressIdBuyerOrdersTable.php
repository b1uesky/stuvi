<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShippingAddressIdBuyerOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('buyer_orders', function(Blueprint $table)
        {
            $table->integer('shipping_address_id')->unsigned();
            $table->foreign('shipping_address_id')->references('id')->on('addresses');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('buyer_orders', function(Blueprint $table)
        {
            $table->dropForeign('buyer_orders_shipping_address_id_foreign');
        });
	}

}
