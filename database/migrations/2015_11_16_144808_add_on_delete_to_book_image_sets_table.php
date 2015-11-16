<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteToBookImageSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_image_sets', function (Blueprint $table) {
            $table->dropForeign('book_image_sets_book_id_foreign');

            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_image_sets', function (Blueprint $table) {
            $table->dropForeign('book_image_sets_book_id_foreign');

            $table->foreign('book_id')
                ->references('id')
                ->on('books');
        });
    }
}
