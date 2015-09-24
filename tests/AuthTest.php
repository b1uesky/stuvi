<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserRegistration()
    {
        $this->withoutEvents();

        $user = [
            'first_name'    => 'Wayne',
            'last_name'     => 'Snyder',
            'password'      => bcrypt('123456'),
            'phone_number'  => '8572655018',
            'university_id' => '1'
        ];

        $email = [
            'email_address' => 'johnwayne@bu.edu'
        ];

        $this->visit('/auth/register')
            ->type($user['first_name'], 'first_name')
            ->type($user['last_name'], 'last_name')
            ->type($email['email_address'], 'email')
            ->type($user['password'], 'password')
            ->type($user['phone_number'], 'phone_number')
            ->select($user['university_id'], 'university_id')
            ->press('Sign Up')
            ->seeInDatabase('users', ['first_name' => $user['first_name']])
            ->seeInDatabase('emails', $email)
            ->seePageIs('/user/activate');
    }

    public function testUserLogin()
    {
        $user = [
            'email'     => 'seller@bu.edu',
            'password'  => '123456'
        ];

        $this->visit('/auth/login')
            ->type($user['email'], 'email')
            ->type($user['password'], 'password')
            ->press('Login')
            ->seePageIs('/home');
    }
}
