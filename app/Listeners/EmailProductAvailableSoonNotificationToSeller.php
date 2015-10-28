<?php

namespace App\Listeners;

use App\Events\ProductIsAvailableSoon;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailProductAvailableSoonNotificationToSeller
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
     * @param  ProductIsAvailableSoon  $event
     * @return void
     */
    public function handle(ProductIsAvailableSoon $event)
    {
        $product = $event->product;
        $seller = $product->seller;
        $book_title = $product->book->title;

        $email = new Email(
            $subject = 'Please schedule a pickup for your book ' . $book_title . '.',
            $to = $seller->primaryEmailAddress(),
            $view = 'emails.product.availableSoonNotification',
            $data = [
                'product'           => $product,
                'first_name'        => $seller->first_name,
                'book_title'        => $book_title
            ]
        );

        $email->send();
    }
}
