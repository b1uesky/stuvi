<?php
/**
 * Created by PhpStorm.
 * User: kingdido999
 * Date: 10/23/15
 * Time: 1:20 PM
 */

namespace App\Helpers;

use Snowfire;

class Email
{
    /**
     * @param string $subject
     * @param string $to
     * @param string $view
     * @param array $data
     */
    public function __construct($subject, $to, $view, $data)
    {
        $this->subject = $subject;
        $this->to = $to;
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * Send the email.
     */
    public function send()
    {
        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);

        $beautymail->send($this->view, $this->data, function($message)
        {
            $message
                ->to($this->to)
                ->subject($this->subject);
        });
    }
}