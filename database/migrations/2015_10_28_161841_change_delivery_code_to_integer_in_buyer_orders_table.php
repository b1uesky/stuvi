<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDeliveryCodeToIntegerInBuyerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyer_orders', function (Blueprint $table) {
            $table->integer('delivery_code')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyer_orders', function (Blueprint $table) {
            $table->tinyInteger('delivery_code')->change();
        });
    }
}
