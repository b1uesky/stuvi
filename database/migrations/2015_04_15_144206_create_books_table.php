<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('title');
            $table->tinyInteger('edition')->default(1);
            $table->string('isbn10', 10);
            $table->string('isbn13', 13);
            $table->smallInteger('num_pages');
            $table->boolean('verified')->default(false);
            $table->string('binding');
            $table->string('language');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('books');
	}

}
