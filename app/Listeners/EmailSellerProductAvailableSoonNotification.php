<?php

namespace App\Listeners;

use App\Events\ProductIsAvailableSoon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire;

class EmailSellerProductAvailableSoonNotification
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

        $data = array(
            'subject'           => 'Please schedule a pickup for your book ' . $book_title . '.',
            'to'                => $seller->primaryEmailAddress(),
            'product'           => $product,
            'first_name'        => $seller->first_name,
            'book_title'        => $book_title
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.product.availableSoonNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
