<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBuyerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyer_payments', function (Blueprint $table) {
            $table->dropColumn('charge_id');
            $table->dropColumn('card_id');
            $table->dropColumn('object');
            $table->dropColumn('card_fingerprint');

            $table->string('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyer_payments', function (Blueprint $table) {
            $table->dropColumn('payment_id');

            $table->string('charge_id', 40);
            $table->string('card_id', 40);
            $table->string('object');
            $table->string('card_fingerprint', 16);
        });
    }
}
