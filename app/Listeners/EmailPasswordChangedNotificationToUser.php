<?php

namespace App\Listeners;

use App\Events\UserPasswordWasChanged;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailPasswordChangedNotificationToUser
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
     * @param  UserPasswordWasChanged  $event
     * @return void
     */
    public function handle(UserPasswordWasChanged $event)
    {
        $user = $event->user;

        $email = new Email(
            $subject = 'Your Stuvi password has changed',
            $to = $user->primaryEmailAddress(),
            $view = 'emails.user.password-changed',
            $data = [
                'user' => $user
            ]
        );

        $email->send();
    }
}
