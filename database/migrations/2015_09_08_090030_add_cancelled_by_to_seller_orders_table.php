<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelledByToSellerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_orders', function (Blueprint $table) {
            $table->integer('cancelled_by')->nullable()->unsigned();
            $table->foreign('cancelled_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_orders', function (Blueprint $table) {
            $table->dropForeign('seller_orders_cancelled_by_foregin');
            $table->dropColumn('cancelled_by');
        });
    }
}
