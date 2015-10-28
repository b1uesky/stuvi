<?php

namespace App\Listeners;

use App\Events\UserEmailWasAdded;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNewEmailAddedConfirmationToUser
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
        $new_email = $event->email;

        $email = new Email(
            $subject = 'Please verify your Stuvi Email address.',
            $to = $new_email->email_address,
            $view = 'emails.user.new-email-added',
            $data = [
                'email' => $new_email
            ]
        );

        $email->send();
    }
}
