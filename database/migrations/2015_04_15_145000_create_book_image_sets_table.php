<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookImageSetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_image_sets', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('book_id')->unsigned();
            $table->string('small_image');
            $table->string('medium_image');
            $table->string('large_image');
			$table->timestamps();

            $table->foreign('book_id')->references('id')->on('books');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_image_sets');
	}

}
