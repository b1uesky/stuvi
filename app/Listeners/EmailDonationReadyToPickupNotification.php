<?php

namespace App\Listeners;

use App\Events\DonationWasAssignedToCourier;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire;

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

        $data = array(
            'subject'               => 'Stuvi courier is ready to pickup your books',
            'to'                    => $donation->donator->primaryEmailAddress(),
            'first_name'            => $donation->donator->first_name,
            'scheduled_pickup_time' => date(config('app.datetime_format'), strtotime($donation->scheduled_pickup_time)),
            'courier_phone_number'  => $donation->courier->phone_number,
            'pickup_code'           => $donation->pickup_code
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.donation.readyToPickupNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
