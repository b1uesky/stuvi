<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkBuyerOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('buyer_orders', function(Blueprint $table)
        {
            $table->foreign('buyer_id')->references('id')->on('users');

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
            $table->dropForeign('buyer_orders_buyer_id_foreign');

        });
	}

}
