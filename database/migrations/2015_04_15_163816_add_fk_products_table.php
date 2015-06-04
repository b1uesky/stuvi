<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('products', function(Blueprint $table)
        {
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('condition_id')->references('id')->on('product_conditions');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('products', function(Blueprint $table)
        {
            $table->dropForeign('products_book_id_foreign');
            $table->dropForeign('products_seller_id_foreign');
            $table->dropForeign('products_condition_id_foreign');
        });
	}

}
