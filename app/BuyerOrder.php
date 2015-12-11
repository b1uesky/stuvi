<?php namespace App;

use App\Events\SellerOrderWasCancelled;
use App\Helpers\Paypal;
use App\Helpers\Price;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class BuyerOrder extends Model
{

    protected $table = 'buyer_orders';
    protected $guarded = [];

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

    /**
     * Get the buyer of this buyer order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyer_id', 'id');
    }

    /**
     * Get the shipping address of this buyer order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipping_address()
    {
        return $this->belongsTo('App\Address', 'shipping_address_id', 'id');
    }

    /**
     * Get all products that is belong to this buyer order.
     *
     * @return Collection
     */
    public function products()
    {
        return $this->seller_orders->map(function ($item)
        {
            return $item->product;
        });
    }

    /**
     * Get all seller orders corresponding to this buyer order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seller_orders()
    {
        return $this->hasMany('App\SellerOrder', 'buyer_order_id', 'id');
    }

    public function courier()
    {
        return $this->belongsTo('App\User', 'courier_id', 'id');
    }

    /*
	|--------------------------------------------------------------------------
	| Accessors & Mutators
	|--------------------------------------------------------------------------
	*/

    public function getSubtotalAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = Price::convertDecimalToInteger($value);
    }

    public function getTaxAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = Price::convertDecimalToInteger($value);
    }

    public function getShippingAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setShippingAttribute($value)
    {
        $this->attributes['shipping'] = Price::convertDecimalToInteger($value);
    }

    public function getDiscountAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = Price::convertDecimalToInteger($value);
    }

    public function getAmountAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = Price::convertDecimalToInteger($value);
    }

    public function getCancelledInStringAttribute()
    {
        return $this->cancelled ? 'Yes' : 'No';
    }

    public function getHTMLShippingAddressAttribute()
    {
        $addr = $this->shipping_address;

        return '<address>' .
            $addr->addressee . '<br>' .
            $addr->address_line1 . '<br>' .
            $addr->address_line2 . '<br>' .
            $addr->city . ', ' . $addr->state_a2 . ' ' . $addr->zip .
        '</address>';
    }

    /*
	|--------------------------------------------------------------------------
	| Query Scopes
	|--------------------------------------------------------------------------
	*/

    /**
     * Get buyer orders that are created after a specific date.
     *
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeCreatedAfter($query, $date)
    {
        return $query->where('created_at', '>=', $date);

    }

    /*
	|--------------------------------------------------------------------------
	| Methods
	|--------------------------------------------------------------------------
	*/

    /**
     * Get seller orders that are not cancelled.
     *
     * @return mixed
     */
    public function getUncancelledSellerOrders()
    {
        return $this->seller_orders()->where('cancelled', false)->get();
    }

    /**
     * Check whether this buyer order is belong to a given user.
     *
     * @param $id  User id
     *
     * @return bool
     */
    public function isBelongTo($id)
    {
        return ($this->buyer_id == $id);
    }

    /**
     * Check whether this buyer order is cancellable.
     */
    public function isCancellable()
    {
        if ($this->isScheduled() || $this->isDelivered() || $this->cancelled)
        {
            return false;
        }

        // if any seller order is picked up by a courier, this buyer order is not cancellable as well.
        foreach ($this->seller_orders as $seller_order)
        {
            if ($seller_order->pickedUp())
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Cancel this buyer order and corresponding seller orders.
     *
     * @param $cancelled_by (user_id)
     */
    public function cancel($cancelled_by)
    {
        // cancel buyer order
        $this->cancelled = true;
        $this->cancelled_time = Carbon::now();
        $this->cancelled_by = $cancelled_by;
        $this->save();

        // cancel seller orders
        foreach ($this->getUncancelledSellerOrders() as $seller_order)
        {
            $cancel_reason = 'Book buyer has cancelled this order.';
            $seller_order->cancel($cancelled_by, $cancel_reason);

            event(new SellerOrderWasCancelled($seller_order));
        }
    }

    /**
     * Check if the order is cancelled by buyer.
     *
     * @return boolean
     */
    public function isCancelledByBuyer()
    {
        return $this->cancelled_by == $this->buyer_id;
    }

    /**
     * Check if the order is scheduled a delivery time and address.
     *
     * @return bool
     */
    public function isScheduled()
    {
        return $this->scheduled_delivery_time && $this->shipping_address_id;
    }

    /**
     * Check whether the order has been assigned to a courier or not
     *
     * @return bool
     */
    public function isAssignedToCourier()
    {
        return !empty($this->courier_id);
    }

    /**
     * Check whether this order is allowed to reconfirm delivery details.
     *
     * @return bool
     */
    public function isDeliverySchedulable()
    {
        if ($this->cancelled || $this->isDelivered() || $this->isAssignedToCourier())
        {
            return false;
        }

        return $this->hasAllSellerOrdersPickedup();
    }

    /**
     * Check if the buyer order is deliverable, that is, check if all products of this buyer order is picked up.
     *
     * @return bool
     */
    public function isDeliverable()
    {
        if ($this->cancelled || $this->isDelivered() || $this->isAssignedToCourier() || !$this->isScheduled())
        {
            return false;
        }

        return $this->hasAllSellerOrdersPickedup();
    }

    /**
     * Check if all seller orders that belong to this buyer order
     * are picked up.
     *
     * @return bool
     */
    public function hasAllSellerOrdersPickedup()
    {

        foreach ($this->seller_orders as $seller_order)
        {
            if (!($seller_order->pickedUp() || $seller_order->cancelled))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Check whether the order has been delivered or not
     *
     * @return bool
     */
    public function isDelivered()
    {
        return !empty($this->time_delivered);
    }

    /**
     * Get the buyer order status and status detail.
     *
     * @return array
     */
    public function getOrderStatus()
    {
        if ($this->cancelled)
        {
            $status = 'Order cancelled';
            $detail = 'Your order has been cancelled.';
        }
        elseif ($this->isDelivered())
        {
            $status = 'Order delivered';
            $detail = 'Your order has been delivered.';
        }
        elseif ($this->isAssignedToCourier())
        {
            $status = 'Order shipped';
            $detail = 'Your order is on its way.';
        }
        elseif ($this->isScheduled())
        {
            $status = 'Assigning a courier';
            $detail = 'Your order is waiting to be assigned to a Stuvi courier.';
        }
        elseif ($this->isDeliverySchedulable())
        {
            $status = 'Delivery details required';
            $detail = 'Please schedule a delivery for this order.';
        }
        else
        {
            $status = 'Preparing your order';
            $detail = 'Your order is being processed by Stuvi.';
        }

        return ['status' => $status, 'detail' => $detail];
    }

    /**
     * Capture authorized payment.
     */
    public function capturePayment()
    {
        $paypal = new Paypal();
        $authorization = $paypal->getAuthorization($this->authorization_id);

        // get the latest buyer order total amount (it may change when a seller order gets cancelled)
        $amount = $this->amount;

        $capture = $paypal->captureAuthorizedPayment($authorization, $amount);

        $this->update([
            'capture_id'    => $capture->getId()
        ]);
    }

    /**
     * Create Paypal payout to sellers.
     */
    public function payout()
    {
        foreach ($this->seller_orders as $seller_order)
        {
            if ($seller_order->product->payout_method == 'paypal')
            {
                $seller_order->payout();
            }
        }
    }

    public static function rules()
    {
        $rules = array(
            'selected_address_id'   => 'required|exists:addresses,id',
            'payment_method'        => 'required|string|in:paypal,cash'
        );

        return $rules;
    }

    public static function confirmDeliveryRules()
    {
        return [
            'address_id'            => 'required|exists:addresses,id',
            'scheduled_delivery_time' => 'required|date'
        ];
    }
}
