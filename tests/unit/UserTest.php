<?php


class UserTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function test_saving_user()
    {
        $user = factory(\App\User::class)->create();
        $email = factory(\App\Email::class)->create([
            'user_id'   => $user->id
        ]);
        $user->update([
            'primary_email_id'   => $email->id
        ]);

        $this->tester->seeRecord('users', $user->toArray());
        $this->tester->seeRecord('emails', $email->toArray());
    }
}