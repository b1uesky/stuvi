<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeBuyerOrderIdNullableInSellerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_orders', function (Blueprint $table) {
            $table->dropForeign('seller_orders_buyer_order_id_foreign');
            $table->dropColumn('buyer_order_id');
        });

        Schema::table('seller_orders', function (Blueprint $table) {
            $table->integer('buyer_order_id')->nullable()->unsigned();
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
            $table->dropColumn('buyer_order_id');
        });

        Schema::table('seller_orders', function (Blueprint $table) {
            $table->integer('buyer_order_id')->unsigned();
            $table->foreign('buyer_order_id')->references('id')->on('buyer_orders');
        });
    }
}
