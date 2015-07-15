<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversityUniversityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('university_university', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('from_uid')->unsigned()->index();
            $table->integer('to_uid')->unsigned()->index();
            $table->foreign('from_uid') ->references('id')->on('universities')->onDelete('cascade');
            $table->foreign('to_uid')->references('id')->on('universities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('university_university');
    }
}
