<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			//$table->string('username');
			$table->string('email')->unique();
			$table->string('password', 60);
            $table->boolean('activated')->default(false);
            $table->char('phone_number', 10)->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('university_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->string('role')->default('u');
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
		Schema::drop('users');
	}

}
