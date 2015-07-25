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
            $table->integer('user_id')->unsigned()->index();
            $table->string('sex');
            $table->date('birthday')->nullbale();
            $table->string('title',50)->nullable();
            $table->string('bio',225)->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('major',225)->nullable();
            $table->string('facebook',225)->nullable();
            $table->string('twitter',225)->nullable();
            $table->string('linkedin',225)->nullable();
            $table->string('website',225)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
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
