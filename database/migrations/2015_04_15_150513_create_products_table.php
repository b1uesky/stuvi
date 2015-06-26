<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->decimal('price');
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
