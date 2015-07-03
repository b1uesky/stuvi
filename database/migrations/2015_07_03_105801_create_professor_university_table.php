<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorUniversityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_university', function(Blueprint $table)
        {
            $table->integer('professor_id') ->unsigned()->index();
            $table->integer('university_id')->unsigned()->index();
            $table->foreign('professor_id') ->references('id')->on('professors')    ->onDelete('cascade');
            $table->foreign('university_id')->references('id')->on('universities')  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('professor_university');
    }
}
