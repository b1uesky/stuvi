<?php

namespace App\Listeners;

use App\Events\SellerOrderWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailSellerOrderConfirmation
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
     * @param  SellerOrderWasCreated  $event
     * @return void
     */
    public function handle(SellerOrderWasCreated $event)
    {
        $seller_order = $event->seller_order;

        $data = array(
            'subject'           => 'Your book ' . $seller_order->book()->title . ' has sold!',
            'to'                => $seller_order->seller()->primaryEmailAddress(),
            'first_name'        => $seller_order->seller()->first_name,
            'book_title'        => $seller_order->book()->title,
            'seller_order_id'   => $seller_order->id,
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.sellerOrder.confirmation', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
