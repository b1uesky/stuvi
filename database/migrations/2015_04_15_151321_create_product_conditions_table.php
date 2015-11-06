<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductConditionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_conditions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->text('description');
			$table->timestamps();
            $table->boolean('broken_binding');
            $table->tinyInteger('general_condition'); // 0: Like new, 1: Good, 2: Acceptable
            $table->tinyInteger('highlights_and_notes');
            $table->tinyInteger('damaged_pages');
            $table->integer('product_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_conditions');
	}

}
