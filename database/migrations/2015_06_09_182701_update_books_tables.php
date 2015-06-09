<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBooksTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('book_image_sets', function(Blueprint $table)
		{
			$table->integer('book_id')->unsigned();
			$table->foreign('book_id')->references('id')->on('books');
		});

		Schema::table('books', function(Blueprint $table)
		{
			$table->dropForeign(['binding_id']);
			$table->dropForeign(['language_id']);
			$table->dropForeign(['image_set_id']);
			$table->dropForeign(['amazon_info_id']);
			
			$table->dropColumn('image_set_id');
			$table->dropColumn('amazon_info_id');
		});

		Schema::drop('book_bindings');
		Schema::drop('book_languages');
		Schema::drop('book_amazon_infos');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
