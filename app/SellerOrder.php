<?php namespace App;

use App\Helpers\Paypal;
use App\Helpers\Price;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SellerOrder extends Model
{
    protected $fillable = [
        'product_id',
        'scheduled_pickup_time',
        'pickup_time',
        'pickup_code',
        'courier_id',
        'buyer_order_id',
        'address_id',
        'cancelled',
        'cancelled_time',
        'cancelled_by',
        'payout_item_id'
    ];

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
     * Cancel the order.
     * Check whether this seller order is cancellable.
     */
    public function isCancellable()
    {
        return !$this->pickedUp() && !$this->cancelled;
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

    /**
     * Generate a 4-digit pickup code for the seller order
     * to verify that the courier has picked up the book.
     *
     * This code will be sent to the seller once he/she has
     * scheduled a pickup time.
     *
     * @return int
     */
    public function generatePickupCode()
    {
        $digits            = 4;
        $this->pickup_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $this->save();
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
    public function assignedToCourier()
    {
        return !empty($this->courier_id);
    }

    /**
     * Check if the seller order has been assigned an address
     *
     * @return bool
     */
    public function assignedAddress()
    {
        return !empty($this->address_id);
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
        if ($this->isTransferred())
        {
            $status = 'Balance Transferred';
            $detail = 'The money has been transferred to your Paypal account.';
        }
        elseif ($this->isDelivered())
        {
            $status = 'Order Delivered';
            $detail = 'Your order has been delivered.';
        }
        elseif ($this->pickedUp())
        {
            $status = 'Picked Up';
            $detail = 'Your order has been picked up at ' . date(config('app.datetime_format'), strtotime($this->pickup_time)) . '.';
        }
        elseif ($this->cancelled)
        {
            $status = 'Order Cancelled';
            $detail = 'Your order has been cancelled.';
        }
        elseif ($this->assignedToCourier())
        {
            $status = 'Courier Assigned';
            $detail = 'Your order has been assigned to a Stuvi courier and the courier is on the way.';
        }
        elseif ($this->isScheduled())
        {
            $status = 'Order Processing';
            $detail = 'Your order is waiting to be assigned to a Stuvi courier.';
        }
        else
        {
            $status = 'Pick-up Details Required';
            $detail = 'Please schedule your pick-up time and location for this order.';
        }

        return ['status' => $status, 'detail' => $detail];
    }

    /**
     * Convert all attributes and related model instances of this seller order to an array.
     *
     * @return array
     */
    public function allToArray()
    {
        $seller_order_arr                                 = $this->toArray();
        $seller_order_arr['seller']                       = $this->seller()->allToArray();
        $seller_order_arr['scheduled_pickup_time']        =
            $this->scheduled_pickup_time ?
            Carbon::createFromFormat('Y-m-d H:i:s', $this->scheduled_pickup_time)
                ->format(config('app.datetime_format')) : '';
        $seller_order_arr['product']                      = $this->product->toArray();
        $seller_order_arr['product']['image']             = $this->product->images->first()->toArray();
        $seller_order_arr['product']['book']              = $this->product->book->toArray();
        $seller_order_arr['product']['book']['authors']   = $this->product->book->authors->toArray();
        $seller_order_arr['product']['book']['image_set'] = $this->product->book->imageSet->toArray();

        return $seller_order_arr;
    }

    /**
     * Check whether this order is allowed to reconfirm pickup details.
     *
     * @return bool
     */
    public function isPickUpConfirmable()
    {
        return !$this->assignedToCourier() && !$this->cancelled;
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

        // update the price of buyer order
        $new_subtotal = $this->buyerOrder->subtotal - $this->product->price;
        $new_total_before_tax = $new_subtotal + $this->buyerOrder->fee - $this->buyerOrder->discount;
        $new_tax = Price::calculateTax($new_total_before_tax);
        $new_amount = $new_total_before_tax + $new_tax;

        $this->buyerOrder->update([
            'subtotal'  => $new_subtotal,
            'tax'       => $new_tax,
            'amount'    => $new_amount
        ]);

        // if all seller orders have been cancelled, cancel the buyer order as well
        if ($this->isCancelledBySeller() && count($this->buyerOrder->getUncancelledSellerOrders()) == 0)
        {
            $this->buyerOrder->cancel($cancelled_by);
        }

        // update book price range
        $this->product->book->addPrice($this->product->price);
    }

    /**
     * Build a query for searching seller orders with books title keywords.
     *
     * @param $keywords
     *
     * @return mixed
     */
    public static function buildQueryWithBookTitle($keywords)
    {
        $keywords = explode(' ', $keywords);

        $query = SellerOrder::join('products as p', 'seller_orders.product_id', '=', 'p.id')
                            ->join('books as b', 'p.book_id', '=', 'b.id');

        foreach ($keywords as $keyword)
        {
            $query = $query->where('b.title', 'LIKE', '%'.$keyword.'%');
        }

        return $query->select('seller_orders.*')->distinct();
    }

    /**
     * Build a query for searching seller orders sold by keywords.
     *
     * @param $keywords
     *
     * @return mixed
     */
    public static function buildQueryWithSellerName($keywords)
    {
        $keywords = explode(' ', $keywords);

        $query = SellerOrder::join('products as p', 'seller_orders.product_id', '=', 'p.id')
                            ->join('users as u', 'p.seller_id', '=', 'u.id');

        foreach ($keywords as $keyword)
        {
            $query = $query->where(function ($query) use ($keyword)
            {
                $query->where('u.first_name', 'LIKE', $keyword);
                $query->orWhere('u.last_name', 'LIKE', $keyword);
            });
        }

        return $query->select('seller_orders.*')->distinct();
    }

    /**
     * create a Paypal payout item.
     *
     * @return array
     */
    public function createPaypalPayoutItem()
    {
        $receiver = $this->seller()->profile->paypal;

        if (empty($receiver))
        {
            return false;
        }

        $value = Price::convertIntegerToDecimal($this->product->price - config('fee.payout_service_fee'));

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

        $item = $this->createPaypalPayoutItem();

        // seller does not paypal account.
        if (!$item)
        {
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
