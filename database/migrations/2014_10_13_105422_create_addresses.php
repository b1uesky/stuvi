<?php

use Illuminate\Database\Migrations\Migration;


class CreateAddresses extends Migration {

	public function up() {
		
		Schema::create('addresses', function($table) {
			$table->increments('id');
            $table->integer('user_id')->unsigned()->index();
			$table->string('addressee', 50);
			$table->string('address_line1', 225);
            $table->string('address_line2', 225)->nullable();
            $table->string('city', 50);
			$table->string('state_a2', 2);
			$table->string('state_name', 60)->nullable();
			$table->string('zip', 11);
			$table->string('country_a2', 2)->default(Config::get('addresses.default_country'));
			$table->string('country_name', 60)->default(Config::get('addresses.default_country_name'));
			$table->string('phone_number', 20)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
		});
		
	}

	public function down() {
		Schema::drop('addresses');
	}

}