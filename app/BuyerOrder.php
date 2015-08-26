<?php namespace App;

use App\Helpers\Paypal;
use App\Helpers\Price;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class BuyerOrder extends Model
{

    protected $table = 'buyer_orders';

    protected $fillable = [
        'buyer_id',
        'courier_id',
        'time_delivered',
        'shipping_address_id',
        'cancelled',
        'cancelled_time',
        'subtotal',
        'tax',
        'fee',
        'discount',
        'amount',
        'payment_id',
        'authorization_id',
        'capture_id'
    ];

    public function decimalSubtotal()
    {
        return Price::convertIntegerToDecimal($this->subtotal);
    }

    public function decimalFee()
    {
        return Price::convertIntegerToDecimal($this->fee);
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
     */
    public function cancel()
    {
        // cancel buyer order
        $this->cancelled = true;
        $this->cancelled_time = Carbon::now();
        $this->save();

        // cancel seller orders
        foreach ($this->seller_orders as $seller_order)
        {
            $seller_order->cancel();
        }
    }

    /**
     * Check whether the order has been assigned to a courier or not
     *
     * @return bool
     */
    public function assignedToCourier()
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

        foreach ($this->seller_orders as $seller_order)
        {
            if (!$seller_order->pickedUp())
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
     * Convert all attributes and related model instances of this buyer order to an array.
     *
     * @return array
     */
    public function allToArray()
    {
        $buyer_order_arr = $this->toArray();
        $buyer_order_arr['buyer'] = $this->buyer->allToArray();
        $buyer_order_arr['shipping_address'] = $this->shipping_address->toArray();
        foreach ($this->products() as $product)
        {
            $temp = $product->toArray();
            $temp['book'] = $product->book->toArray();
            $temp['image'] = $product->images->first()->toArray();
            $temp['book']['authors'] = $product->book->authors->toArray();
            $temp['book']['image_set'] = $product->book->imageSet->toArray();
            $buyer_order_arr['products'][] = $temp;
        }

        return $buyer_order_arr;
    }

    /**
     * Get all stripe refunds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
//    public function stripeRefunds()
//    {
//        return $this->hasMany('App\StripeRefund');
//    }

    /**
     * Check if this buyer order has amount that needs to refund.
     *
     * @return bool
     */
//    public function isRefundable()
//    {
//        return $this->refundableAmount() > 0;
//    }

    /**
     * Calculate the total amount in cent that needs to refund.
     *
     * @return int
     */
//    public function refundableAmount()
//    {
//        // get all cancelled seller orders
//        $cancelled_orders = $this->seller_orders()->where('cancelled', true)->get();
//        $amount = 0;
//        foreach ($cancelled_orders as $order)
//        {
//            $amount += intval($order->product->price * (1 + config('tax.MA')));
//        }
//
//        // calculate the amount refunded
//        $refunded = 0;
//        foreach ($this->stripeRefunds as $stripe_refund)
//        {
//            $refunded += $stripe_refund->amount;
//        }
//
//        // get the amount needed to refund.
//        // if the subtotal of all cancelled seller order is larger than the buyer payment,
//        // we can refund at most the payment - the refunded amount.
//        $amount = $this->buyer_payment->amount >= $amount ? $amount-$refunded : $this->buyer_payment->amount-$refunded;
//
//        return $amount;
//    }

    /**
     * Refund a given amount to buyer.
     *
     * @param $amount
     * @param $operator_id
     *
     * @return string|static
     */
//    public function refund($amount, $operator_id)
//    {
//        \Stripe\Stripe::setApiKey(StripeKey::getSecretKey());
//
//        try
//        {
//            $ch = \Stripe\Charge::retrieve($this->buyer_payment->charge_id);
//            $re = $ch->refunds->create(['amount' => $amount]);
//
//            $refund = StripeRefund::create([
//                'buyer_order_id' => $this->id,
//                'refund_id'      => $re['id'],
//                'amount'         => $re['amount'],
//                'operator_id'    => $operator_id,
//            ]);
//
//            return $refund;
//        }
//        catch (\Stripe\Error\InvalidRequest $e)
//        {
//            // Invalid parameters were supplied to Stripe's API
//            return $e->getMessage();
//        }
//        catch (\Stripe\Error\Authentication $e)
//        {
//            // Authentication with Stripe's API failed
//            // (maybe you changed API keys recently)
//            return $e->getMessage();
//        }
//        catch (\Stripe\Error\ApiConnection $e)
//        {
//            // Network communication with Stripe failed
//            return $e->getMessage();
//        }
//        catch (\Stripe\Error\Base $e)
//        {
//            // Display a very generic error to the user, and maybe send
//            // yourself an email
//            return $e->getMessage();
//        }
//        catch (Exception $e)
//        {
//            // Something else happened, completely unrelated to Stripe
//            return $e->getMessage();
//        }
//    }

    /**
     * Get the buyer order status and status detail.
     *
     * @return array
     */
    public function getOrderStatus()
    {
        if ($this->cancelled)
        {
            $status = 'Order Cancelled';
            $detail = 'Your order has been cancelled.';
        }
        elseif ($this->isDelivered())
        {
            $status = 'Order Delivered';
            $detail = 'Your order has been delivered.';
        }
        else
        {
            $status = 'Order Processing';
            $detail = 'Your order is being processed by Stuvi.';
        }

        return ['status' => $status, 'detail' => $detail];
    }

    /**
     * Email buyer the buyer order confirmation
     */
    public function emailOrderConfirmation()
    {
        // convert the buyer order and corresponding objects to an array
        $buyer_order_arr = $this->allToArray();
        Mail::queue('emails.buyerOrderConfirmation', ['buyer_order' => $buyer_order_arr], function ($message) use ($buyer_order_arr)
        {
            $message->to($buyer_order_arr['buyer']['email'])->subject('Confirmation of your order #' . $this->id);
        });
    }

    /**
     * Capture authorized payment.
     */
    public function capturePayment()
    {
        // TODO: only capture the total amount of product delivered.
        $paypal = new Paypal();
        $authorization = $paypal->getAuthorization($this->authorization_id);
        $capture = $paypal->captureAuthorizedPayment($authorization);

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
            $seller_order->payout();
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
}
