<?php

namespace App\Listeners;

use App\Events\UserPasswordWasChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailUserPasswordChangedNotification
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

        $data = array(
            'subject'           => 'Your Stuvi password has changed.',
            'to'                => $user->primaryEmailAddress(),
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.passwordChanged', ['user' => $user], function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
