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
            $table->string('author');
            $table->string('isbn', 13);
            $table->string('publisher');
            $table->date('publication_date');
            $table->string('manufacturer');
            $table->smallInteger('num_pages');
            $table->integer('binding_id')->unsigned()->nullable();
            $table->integer('image_set_id')->unsigned()->nullable();
            $table->integer('language_id')->unsigned()->nullable();
            $table->integer('amazon_info_id')->unsigned()->nullable();
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
