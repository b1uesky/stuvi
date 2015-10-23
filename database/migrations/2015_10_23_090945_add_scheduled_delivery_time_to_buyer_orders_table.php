<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScheduledDeliveryTimeToBuyerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyer_orders', function (Blueprint $table) {
            $table->timestamp('scheduled_delivery_time')->nullable();
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
            $table->dropColumn('scheduled_delivery_time');
        });
    }
}
