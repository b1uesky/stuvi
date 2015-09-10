<?php

namespace App\Listeners;

use App\Events\UserEmailWasAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailUserEmailAddedConfirmation
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
     * @param  UserEmailWasAdded  $event
     * @return void
     */
    public function handle(UserEmailWasAdded $event)
    {
        $email = $event->email;

        $data = array(
            'subject'           => 'Please verify your Stuvi Email address.',
            'to'                => $email->email_address,
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.emailConfirmation', ['email' => $email], function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
