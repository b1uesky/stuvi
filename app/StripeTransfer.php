<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeTransfer extends Model
{
    protected $fillable = ['seller_order_id', 'transfer_id', 'object', 'amount', 'currency', 'status', 'type',
                            'balance_transaction', 'destination', 'destination_payment', 'source_transaction',
                            'application_fee'];


}
