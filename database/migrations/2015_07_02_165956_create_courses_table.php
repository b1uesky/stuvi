<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->integer('major_id')->unsigned()->nullable();
            $table->integer('professor_id')->unsigned()->nullable();

            $table->foreign('major_id')     ->references('id')->on('majors');
            $table->foreign('professor_id') ->references('id')->on('professors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classes');
    }
}
