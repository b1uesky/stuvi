<?php

namespace App\Listeners;

use App\BookReminder;
use App\Events\ProductWasCreated;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailBookAvailableNotificationToUsers
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
        $book = $product->book;
        $users = BookReminder::getUsersByBookID($book->id);

        foreach ($users as $u)
        {
            // do not send email to seller
            if ($product->seller_id != $u->id)
            {
                $email = new Email(
                    $subject = 'Stuvi Textbook Reminder: '. $book->title .' is now available',
                    $to = $u->primaryEmailAddress(),
                    $view = 'emails.reminder.textbook-available',
                    $data = [
                        'product'   => $product,
                        'book'      => $book,
                        'user'      => $u
                    ]
                );

                $email->send();
            }
        }


    }
}
