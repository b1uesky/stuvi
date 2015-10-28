<?php

namespace App\Listeners;

use App\Events\DonationWasCreated;
use App\Helpers\DateTime;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailDonationPickupNotificationToStuvi
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
     * @param  DonationWasCreated  $event
     * @return void
     */
    public function handle(DonationWasCreated $event)
    {
        $donation = $event->donation;

        $email = new Email(
            $subject = 'Pickup book donation: #' . $donation->id,
            $to = 'express@stuvi.com',
            $view = 'emails.express.pickup-donation',
            $data = [
                'donation'              => $donation,
                'scheduled_pickup_time' => DateTime::showDatetime($donation->scheduled_pickup_time),
            ]
        );

        $email->send();
    }
}
