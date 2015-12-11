<?php namespace App;

use App\Events\BuyerOrderWasCancelled;
use App\Helpers\DateTime;
use App\Helpers\Paypal;
use App\Helpers\Price;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SellerOrder extends Model
{
    protected $table = 'seller_orders';
    protected $guarded = [];

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

    /**
     * Return the seller order address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * Get the buyer order that this seller order belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyerOrder()
    {
        return $this->belongsTo('App\BuyerOrder', 'buyer_order_id', 'id');
    }

    /**
     * Get the product of this seller order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * Return the seller order book.
     *
     * @return Book
     */
    public function book()
    {
        return $this->product->book;
    }

    /**
     * Return the seller that owns this seller order.
     *
     * @return User
     */
    public function seller()
    {
        return $this->product->seller;
    }

    /**
     * Return the courier who is assigned to this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courier()
    {
        return $this->belongsTo('App\User', 'courier_id');
    }

    /*
	|--------------------------------------------------------------------------
	| Accessors & Mutators
	|--------------------------------------------------------------------------
	*/

    public function getCashPaidAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setCashPaidAttribute($value)
    {
        $this->attributes['cash_paid'] = Price::convertDecimalToInteger($value);
    }

    public function getHTMLAddressAttribute()
    {
        $addr = $this->address;

        if ($addr)
        {
            return '<address>'.
            $addr->addressee.'<br>'.
            $addr->address_line1.'<br>'.
            $addr->address_line2.'<br>'.
            $addr->city.', '.$addr->state_a2.' '.$addr->zip.
            '</address>';
        }

        return null;
    }

    public function getCancelledInStringAttribute()
    {
        return $this->cancelled ? 'Yes' : 'No';
    }

    /*
	|--------------------------------------------------------------------------
	| Query Scopes
	|--------------------------------------------------------------------------
	*/

    /**
     * Get seller orders that are created after a specific date.
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
     * Cancel the order.
     * Check whether this seller order is cancellable.
     */
    public function isCancellable()
    {
        return !$this->scheduledPickupTime() && !$this->pickedUp() && !$this->cancelled;
    }

    /**
     * Get the order cancelled time.
     *
     * @return mixed
     */
    public function getCancelledTime()
    {
        return $this->cancelled_time->toDateTimeString();
    }

    /**
     * Check if the order is cancelled by seller.
     *
     * @return boolean
     */
    public function isCancelledBySeller()
    {
        return $this->cancelled_by == $this->seller()->id;
    }

    /**
     * Check whether this seller order is belong to a given user.
     *
     * @param $id  A user id
     *
     * @return bool
     */
    public function isBelongTo($id)
    {
        return ($this->product->seller_id == $id);
    }

    /**
     * Return if this seller order has been scheduled a pickup time.
     *
     * @return bool
     */
    public function scheduledPickupTime()
    {
        return !empty($this->scheduled_pickup_time);
    }

    /**
     * Check if the seller order is picked up by a courier.
     *
     * @return bool
     */
    public function pickedUp()
    {
        return !empty($this->pickup_time);
    }

    /**
     * Check if the seller order has been assigned to a courier.
     *
     * @return bool
     */
    public function isAssignedToCourier()
    {
        return !empty($this->courier_id);
    }

    /**
     * Check if the seller order has been assigned an address
     *
     * @return bool
     */
    public function isAddsignedAddress()
    {
        return !empty($this->address_id);
    }

    /**
     * Check whether the seller has scheduled a pickup time and address.
     *
     * @return bool
     */
    public function isScheduled()
    {
        return ($this->scheduled_pickup_time && $this->address_id);
    }

    /**
     * Check whether this seller order has been delivered or not
     *
     * @return bool
     */
    public function isDelivered()
    {
        if ($this->isSoldToStuvi())
        {
            return !$this->cancelled && $this->pickedUp();
        }

        return !$this->cancelled && $this->buyerOrder->isDelivered();
    }

    /**
     * Check whether the amount of this seller order is transferred to seller's Paypal account.
     *
     * @return bool
     */
    public function isTransferred()
    {
        return !is_null($this->payout_item_id);
    }

    /**
     * Get the seller order status and status detail.
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
        elseif ($this->isTransferred())
        {
            $status = 'Balance transferred';
            $detail = 'The money has been transferred to your Paypal account.';
        }
        elseif ($this->isDelivered())
        {
            if ($this->isSoldToUser())
            {
                $status = 'Order delivered';
                $detail = 'Your book has been delivered to the buyer.';
            }

            if ($this->isSoldToStuvi())
            {
                $status = 'Order delivered';
                $detail = 'Your book trade-in has been received by Stuvi.';
            }
        }
        elseif ($this->pickedUp())
        {
            $status = 'Order picked up';
            $detail = 'Your order has been picked up at ' . DateTime::showDatetime($this->pickup_time) . '.';
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
        else
        {
            $status = 'Pick-up details required';
            $detail = 'Please schedule a pickup for this order.';
        }

        return ['status' => $status, 'detail' => $detail];
    }

    /**
     * Check whether this order is allowed to reconfirm pickup details.
     *
     * @return bool
     */
    public function isPickupSchedulable()
    {
        return !$this->isAssignedToCourier() && !$this->cancelled;
    }

    /**
     * Check if the order is sold to Stuvi.
     *
     * @return bool
     */
    public function isSoldToStuvi()
    {
        return !$this->buyer_order_id;
    }

    /**
     * Check if the order is sold to a user.
     *
     * @return bool
     */
    public function isSoldToUser()
    {
        return $this->buyer_order_id;
    }


    /**
     * Cancel a seller order.
     *
     * @param $cancelled_by
     * @param string $cancel_reason
     */
    public function cancel($cancelled_by, $cancel_reason)
    {
        $this->cancelled      = true;
        $this->cancelled_time = Carbon::now();
        $this->cancelled_by   = $cancelled_by;
        $this->cancel_reason  = $cancel_reason;
        $this->product->sold  = false;
        $this->push();

        if ($this->isSoldToUser())
        {
            // update the price of buyer order
            $new_subtotal = $this->buyerOrder->subtotal - $this->product->price;
            $new_total_before_tax = $new_subtotal + $this->buyerOrder->shipping - $this->buyerOrder->discount;
            $new_tax = Price::calculateTax($new_total_before_tax);
            $new_amount = $new_total_before_tax + $new_tax;

            $this->buyerOrder->subtotal = $new_subtotal;
            $this->buyerOrder->tax = $new_tax;
            $this->buyerOrder->amount = $new_amount;
            $this->buyerOrder->save();

            // if all seller orders have been cancelled, cancel the buyer order as well
            if ($this->isCancelledBySeller() && count($this->buyerOrder->getUncancelledSellerOrders()) == 0)
            {
                $this->buyerOrder->cancel($cancelled_by);

                event(new BuyerOrderWasCancelled($this->buyerOrder));
            }

            // update book price range
            $this->product->book->addPrice($this->product->price);
        }

    }

    /**
     * create a Paypal payout item.
     *
     * @param decimal $value
     * @return array
     */
    public function createPaypalPayoutItem($value)
    {
        $receiver = $this->seller()->profile->paypal;

        if (empty($receiver))
        {
            return false;
        }

        $item = array(
            'recipient_type'    => 'EMAIL',
            'receiver'          => $receiver,
            'note'              => 'Thank you for your trust on Stuvi!',
            'sender_item_id'    => $this->id,
            'amount'            => array(
                'value'             => $value,
                'currency'          => 'USD',
            )
        );

        return $item;
    }

    /**
     * Payout the seller via paypal.
     *
     * @return bool|\PayPal\Api\PayoutItemDetails
     */
    public function payout()
    {
        // not delivered.
        if (!$this->isDelivered())
        {
            return false;
        }

        // check if payout method is paypal
        if ($this->product->payout_method != 'paypal')
        {
            return false;
        }

        // determine what price to pay
        if ($this->isSoldToUser())
        {
            $value = $this->product->price - config('sale.paypal_payout_fee');
        }

        if ($this->isSoldToStuvi())
        {
            $value = $this->product->trade_in_price - config('sale.paypal_payout_fee');
        }

        $item = $this->createPaypalPayoutItem($value);

        // seller does not have paypal account.
        if (!$item)
        {
            // TODO: notify seller
            return false;
        }

        $paypal = new Paypal();
        $payout_batch = $paypal->createSinglePayout($item);
        $payout_batch_status = $paypal->getPayoutBatchStatus($payout_batch);
        $payout_item = $payout_batch_status->getItems()[0];

        $this->update([
            'payout_item_id' => $payout_item->getPayoutItemId(),
        ]);

        return $payout_item;
    }

    public static function confirmPickupRules()
    {
        $rules = array(
            'address_id'            => 'required|exists:addresses,id',
            'scheduled_pickup_time' => 'required|date'
        );

        return $rules;
    }
}
