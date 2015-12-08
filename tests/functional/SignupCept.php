<?php
$faker = \Faker\Factory::create();

$user = [
    'first_name'    => $faker->firstName,
    'last_name'     => $faker->lastName,
    'email'         => $faker->firstName.'@bu.edu',
    'password'      => $faker->password(6),
];

$I = new FunctionalTester($scenario);
$I->wantTo('sign up as regular user');
$I->amOnPage('/auth/register');

$I->fillField('first_name', $user['first_name']);
$I->fillField('last_name', $user['last_name']);
$I->fillField('#signup-body input[name="email"]', $user['email']);
$I->fillField('#signup-body input[name="password"]', $user['password']);
$I->fillField('phone_number', '8572655018');
$I->selectOption('university_id', 1);

$I->click('#signup-body button[type="submit"]');
$I->see('Welcome to Stuvi');
$I->seeRecord('users', [
    'first_name'    => $user['first_name'],
    'last_name'     => $user['last_name']
]);
$I->seeRecord('emails', [
    'email_address' => $user['email']
]);
