<?php

namespace App\Listeners;

use App\Events\ContactMessageWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailContactMessageToStaff
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
     * @param  ContactMessageWasCreated  $event
     * @return void
     */
    public function handle(ContactMessageWasCreated $event)
    {
        $contact = $event->contact;

        $data = array(
            'subject'           => 'Message from ' . $contact->name,
            'name'              => $contact->name,
            'from'              => $contact->email,
            'to'                => config('customer_service.email'),
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.contact', ['contact' => $contact], function($message) use ($data)
        {
            $message
                ->from($data['from'], $data['name'])
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
