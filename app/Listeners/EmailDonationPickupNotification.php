<?php

namespace App\Listeners;

use App\Events\DonationWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire;

class EmailDonationPickupNotification
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

        $data = array(
            'subject'               => 'Pickup book donation: #' . $donation->id,
            'to'                    => 'express@stuvi.com',
            'donation'              => $donation,
            'scheduled_pickup_time' => date(config('app.datetime_format'), strtotime($donation->scheduled_pickup_time)),
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.express.pickupDonationNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
