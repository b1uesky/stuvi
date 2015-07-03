<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->tinyInteger('general_condition'); // 0: Brand new, 1: Excellent, 2: Good, 3: Acceptable
            $table->tinyInteger('highlights_and_notes');
            $table->tinyInteger('damaged_pages');
            $table->integer('product_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products');
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
