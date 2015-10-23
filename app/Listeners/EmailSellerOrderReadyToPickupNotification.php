<?php

namespace App\Listeners;

use App\Events\SellerOrderWasAssignedToCourier;
use App\Helpers\DateTime;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailSellerOrderReadyToPickupNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SellerOrderWasAssignedToCourier  $event
     * @return void
     */
    public function handle(SellerOrderWasAssignedToCourier $event)
    {
        $seller_order = $event->seller_order;

        $data = array(
            'subject'           => 'Stuvi courier is ready to pickup your textbook: ' . $seller_order->book()->title . '.',
            'to'                => $seller_order->seller()->primaryEmailAddress(),
            'first_name'        => $seller_order->seller()->first_name,
            'book_title'        => $seller_order->book()->title,
            'seller_order_id'   => $seller_order->id,
            'time'              => DateTime::showDatetime($seller_order->scheduled_pickup_time),
            'pickup_code'       => $seller_order->pickup_code,
            'courier_phone_number'  => $seller_order->courier->phone_number
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.sellerOrder.readyToPickupNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
