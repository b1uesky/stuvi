<?php

namespace App\Listeners;

use Aloha\Twilio\Twilio;
use App\Events\ProductWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageProductCreatedNotificationToStuvi
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
     * @param  ProductWasCreated  $event
     * @return void
     */
    public function handle(ProductWasCreated $event)
    {
        $product = $event->product;

        $twilio = new Twilio(
            config('twilio.twilio.connections.twilio.sid'),
            config('twilio.twilio.connections.twilio.token'),
            config('twilio.twilio.connections.twilio.from')
        );

        $phone_number = config('customer_service.phone');
        $message = 'Product #' . $product->id . ' was created: '.url('textbook/buy/product/'.$product->id);

        $twilio->message($phone_number, $message);

        if (app()->environment() == 'production' && !env('APP_DEBUG')) {
            $twilio->message('8572064789', $message);
            $twilio->message('8572084775', $message);
        }
    }
}
