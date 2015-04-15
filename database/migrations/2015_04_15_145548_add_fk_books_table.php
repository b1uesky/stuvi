<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('books', function(Blueprint $table)
		{
			$table->foreign('binding_id')->references('id')->on('book_bindings');
            $table->foreign('image_set_id')->references('id')->on('book_image_sets');
            $table->foreign('language_id')->references('id')->on('book_languages');
            $table->foreign('amazon_info_id')->references('id')->on('book_amazon_infos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('books', function(Blueprint $table)
		{
			//
		});
	}

}
