<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayoutItemIdToSellerOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_orders', function (Blueprint $table) {
            $table->string('payout_item_id')->nullable()->unique();
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
            $table->dropColumn('payout_item_id');
        });
    }
}
