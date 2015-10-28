<?php

namespace App\Listeners;

use App\Events\ProductWasRejected;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailProductRejectedNotificationToSeller
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
     * @param  ProductWasRejected  $event
     * @return void
     */
    public function handle(ProductWasRejected $event)
    {
        $product = $event->product;
        $seller = $product->seller;
        $book_title = $product->book->title;

        $email = new Email(
            $subject = 'Sorry, your book ' . $book_title . ' is not accepted by Stuvi.',
            $to = $seller->primaryEmailAddress(),
            $view = 'emails.product.rejectedNotification',
            $data = [
                'product'           => $product,
                'first_name'        => $seller->first_name,
                'book_title'        => $book_title
            ]
        );

        $email->send();
    }
}
