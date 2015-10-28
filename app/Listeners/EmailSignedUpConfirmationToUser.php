<?php

namespace App\Listeners;

use App\Events\UserWasSignedUp;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Session;

class EmailSignedUpConfirmationToUser
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
     * @param  UserWasSignedUp  $event
     * @return void
     */
    public function handle(UserWasSignedUp $event)
    {
        $user = $event->user;

        $email = new Email(
            $subject = 'Welcom to Stuvi!',
            $to = $user->primaryEmailAddress(),
            $view = 'emails.user.signed-up',
            $data = [
                'first_name'        => $user->first_name,
                'return_to'         => urlencode(Session::get('url.intended', '/user/activated')),
                'verification_code' => $user->collegeEmail()->verification_code
            ]
        );

        $email->send();
    }
}
