<?php
$faker = \Faker\Factory::create();
$email = $faker->email;

$I = new FunctionalTester($scenario);
$I->wantTo('add a new email address');

$I->amLoggedAs(\App\User::find(3));
$I->amOnPage('/user/email');
$I->see('Email settings');

$I->fillField('email', $email);
$I->click('Submit');
$I->seeElement('.alert-success');
$I->see($email);