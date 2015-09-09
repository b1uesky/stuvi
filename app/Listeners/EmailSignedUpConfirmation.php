<?php

namespace App\Listeners;

use App\Events\UserWasSignedUp;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Session;
use Snowfire;

class EmailSignedUpConfirmation
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

        $data = array(
            'to'                => $user->collegeEmail()->email_address,
            'first_name'        => $user->first_name,
            'return_to'         => urlencode(Session::get('url.intended', '/home')),
            'verification_code' => $user->collegeEmail()->verification_code
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.welcome', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject('Welcome to Stuvi!');
        });
    }
}
