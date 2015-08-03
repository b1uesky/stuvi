<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('price');
            $table->integer('book_id')->unsigned();
            $table->integer('seller_id')->unsigned();
            $table->boolean('sold')->default(false);
            $table->boolean('verified')->default(false);
			$table->timestamps();


            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('seller_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('products');
	}

}
