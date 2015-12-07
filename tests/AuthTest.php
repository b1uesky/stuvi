<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_registration()
    {
        $this->withoutEvents();

        $faker = \Faker\Factory::create();

        $user = [
            'first_name'    => $faker->firstName,
            'last_name'     => $faker->lastName,
            'password'      => $faker->password(6),
            'phone_number'  => $faker->numerify('857#######'),
            'university_id' => 1
        ];

        $email = [
            'email_address' => $faker->firstName . '@bu.edu'
        ];

        $this->visit('/auth/register')
            ->type($user['first_name'], 'first_name')
            ->type($user['last_name'], 'last_name')
            ->type($email['email_address'], 'email')
            ->type($user['password'], 'password')
            ->type($user['phone_number'], 'phone_number')
            ->select($user['university_id'], 'university_id')
            ->press('Sign Up')
            ->seeInDatabase('users', [
                'first_name'    => $user['first_name'],
                'last_name'     => $user['last_name'],
                'phone_number'  => $user['phone_number'],
                'university_id' => $user['university_id']
            ])
            ->seeInDatabase('emails', $email)
            ->seePageIs('/user/activate');
    }
}
