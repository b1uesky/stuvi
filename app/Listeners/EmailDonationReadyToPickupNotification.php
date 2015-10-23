<?php

namespace App\Listeners;

use App\Events\DonationWasAssignedToCourier;
use App\Helpers\DateTime;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailDonationReadyToPickupNotification
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
     * @param  DonationWasAssignedToCourier  $event
     * @return void
     */
    public function handle(DonationWasAssignedToCourier $event)
    {
        $donation = $event->donation;

        $email = new Email(
            $subject = 'We are ready to pickup your book donation.',
            $to = $donation->donator->primaryEmailAddress(),
            $view = 'emails.donation.readyToPickupNotification',
            $data = [
                'first_name'            => $donation->donator->first_name,
                'scheduled_pickup_time' => DateTime::showDatetime($donation->scheduled_pickup_time),
                'courier_phone_number'  => $donation->courier->phone_number,
                'pickup_code'           => $donation->pickup_code
            ]
        );

        $email->send();
    }
}
