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


    /**
     * Get seller orders that are not cancelled.
     *
     * @return mixed
     */
    public function getUncancelledSellerOrders()
    {
        return $this->seller_orders()->where('cancelled', false)->get();
    }

    public function decimalSubtotal()
    {
        return Price::convertIntegerToDecimal($this->subtotal);
    }

    public function decimalShipping()
    {
        return Price::convertIntegerToDecimal($this->shipping);
    }

    public function decimalTax()
    {
        return Price::convertIntegerToDecimal($this->tax);
    }

    public function decimalDiscount()
    {
        return Price::convertIntegerToDecimal($this->discount);
    }

    public function decimalAmount()
    {
        return Price::convertIntegerToDecimal($this->amount);
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
        if ($this->isDelivered() || $this->cancelled)
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
     * Check if the buyer order is deliverable, that is, check if all products of this buyer order is picked up.
     *
     * @return bool
     */
    public function isDeliverable()
    {
        if ($this->cancelled || $this->isDelivered() || $this->courier_id)
        {
            return false;
        }

        // if there is more than one seller orders that are not cancelled and not pickup,
        // then this buyer order is not deliverable.
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
        elseif ($this->isDeliverable())
        {
            $status = 'Delivery details required';
            $detail = 'Please schedule your delivery time and location for this order.';
        }
        else
        {
            $status = 'Preparing Your Order';
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
        $amount = $this->decimalAmount();

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

    /**
     * Build a query for searching buyer orders sold by keywords.
     *
     * @param $keywords
     *
     * @return mixed
     */
    public static function buildQueryWithBuyerName($keywords)
    {
        $keywords = explode(' ', $keywords);

        $query = BuyerOrder::join('users as u', 'buyer_orders.buyer_id', '=', 'u.id');

        foreach ($keywords as $keyword)
        {
            $query = $query->where(function ($query) use ($keyword)
            {
                $query->where('u.first_name', 'LIKE', $keyword);
                $query->orWhere('u.last_name', 'LIKE', $keyword);
            });
        }

        return $query->select('buyer_orders.*')->distinct();
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
