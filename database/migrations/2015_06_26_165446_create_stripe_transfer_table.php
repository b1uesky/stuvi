<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripeTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //$a = { "id": "tr_16I3YYEevVfPfVHNK9vbji6q", "object": "transfer", "created": 1435350974, "date": 1435350974, "livemode": false, "amount": 4999, "currency": "usd", "reversed": false, "status": "pending", "type": "stripe_account", "reversals": { "object": "list", "total_count": 0, "has_more": false, "url": "\/v1\/transfers\/tr_16I3YYEevVfPfVHNK9vbji6q\/reversals", "data": [] }, "balance_transaction": "txn_16I3YYEevVfPfVHNzfne45EC", "destination": "acct_15rzm7AhfoQ8hQN2", "destination_payment": "py_16I3YYAhfoQ8hQN2QziQ19a2", "description": null, "failure_message": null, "failure_code": null, "amount_reversed": 0, "metadata": [], "statement_descriptor": null, "recipient": null, "source_transaction": null, "application_fee": "fee_6V3fTpuQthEozL" }
        Schema::create('stripe_transfers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('seller_order_id')->unsigned();
            $table->string('transfer_id');
            $table->string('object');
            $table->integer('amount');
            $table->string('currency');
            $table->string('status');
            $table->string('type');
            $table->string('balance_transaction');
            $table->string('destination');
            $table->string('destination_payment');
            $table->string('source_transaction');
            $table->string('application_fee');

            $table->timestamps();

            $table->foreign('seller_order_id')->references('id')->on('seller_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stripe_transfers');
    }
}
