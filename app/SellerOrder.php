<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SellerOrder extends Model
{
    protected $fillable = ['product_id', 'scheduled_pickup_time', 'pickup_time', 'pickup_code', 'courier_id',
                           'buyer_order_id', 'address_id', 'cancelled', 'cancelled_time',
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
     * Cancel a seller order.
     */
    public function cancel()
    {
        $this->cancelled      = true;
        $this->cancelled_time = Carbon::now();
        $this->product->sold  = false;
        $this->push();
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
     * Get the Stripe transfer record of this seller order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stripeTransfer()
    {
        return $this->hasOne('App\StripeTransfer');
    }

    /**
     * Check whether the seller has scheduled a pickup time.
     *
     * @return bool
     */
    public function isScheduled()
    {
        return (!empty($this->scheduled_pickup_time));
    }

    /**
     * Check whether this seller order has been delivered or not
     *
     * @return bool
     */
    public function isDelivered()
    {
        return $this->buyerOrder->isDelivered();
    }

    /**
     * Check whether the amount of this seller order is transferred to seller's Stripe account.
     *
     * @return bool
     */
    public function isTransferred()
    {
        return !$this->stripeTransfer()->get()->isEmpty();
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
            $detail = 'The money has been transferred to your Stripe account.';
        }
        elseif ($this->isDelivered())
        {
            $status = 'Order Delivered';
            $detail = 'Your order has been delivered to the buyer.';
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
        elseif ($this->isScheduled())
        {
            $status = 'Waiting For Pick Up';
            $detail = 'Your order is waiting for a Stuvi courier to pick up.';
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
        $seller_order_arr['product']                      = $this->product->toArray();
        $seller_order_arr['product']['image']             = $this->product->images->first()->toArray();
        $seller_order_arr['product']['book']              = $this->product->book->toArray();
        $seller_order_arr['product']['book']['authors']   = $this->product->book->authors->toArray();
        $seller_order_arr['product']['book']['image_set'] = $this->product->book->imageSet->toArray();

        return $seller_order_arr;
    }


    /**
     * Email seller the seller order confirmation
     */
    public function emailOrderConfirmation()
    {
        // convert the seller order and corresponding objects to an array
        $seller_order_arr = $this->allToArray();

        Mail::queue('emails.sellerOrderConfirmation', ['seller_order' => $seller_order_arr], function ($message) use ($seller_order_arr)
        {
            $message->to($seller_order_arr['seller']['email'])->subject('Your book ' . $this->product->book->title . ' has sold!');
        });
    }
}
