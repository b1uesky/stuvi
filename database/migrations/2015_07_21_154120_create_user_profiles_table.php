<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function($table){
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index;
            $table->integer('sex')->nullable();
            $table->date('birthday')->nullbale();
            $table->string('nickname')->nullable();
            $table->string('bio')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('major')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->reference('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_profiles');
    }
}
