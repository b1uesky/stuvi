<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 7/9/15
 * Time: 2:38 PM
 */

use Aloha\Twilio\Twilio;
use Illuminate\Support\Facades\Config;

class TwilioMessageTest extends TestCase {

    /**
     * Test sending message.
     *
     * @return void
     */
    public function testSendMessage()
    {
        $twilio = new Twilio(
            Config::get('twilio.twilio.connections.twilio.sid'),
            Config::get('twilio.twilio.connections.twilio.token'),
            Config::get('twilio.twilio.connections.twilio.from')
        );

        $twilio->message('+18572064789', 'Hello World!');
    }

}