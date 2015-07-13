<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeRefund extends Model
{
    protected $fillable = ['buyer_order_id', 'refund_id', 'amount', 'operator_id'];


}
