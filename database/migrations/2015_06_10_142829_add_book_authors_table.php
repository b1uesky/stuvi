<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBookAuthorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_authors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('book_id')->unsigned();
			$table->foreign('book_id')->references('id')->on('books');
			$table->string('full_name');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->timestamps();
		});

		Schema::table('books', function(Blueprint $table)
		{
			$table->dropColumn('author');
		});
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
