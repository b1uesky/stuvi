<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testNewUserSignedUp()
    {
        $this->withoutEvents();

        $this->visit('/auth/register')
            ->type('John', 'first_name')
            ->type('Wayne', 'last_name')
            ->type('johnwayne@bu.edu', 'email')
            ->type('123456', 'password')
            ->type('8572655018', 'phone_number')
            ->select('1', 'university_id')
            ->press('Sign Up')
            ->seePageIs('/user/activate');
    }

    public function testUserLoggedIn()
    {
        $this->visit('/auth/login')
            ->type('seller@bu.edu', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/home');
    }
}
