<?php
$faker = \Faker\Factory::create();
$name = $faker->name;
$email = $faker->email;
$message = $faker->paragraph();

$I = new FunctionalTester($scenario);
$I->wantTo('contact stuvi');

$I->amOnPage('/contact');
$I->see('Contact us');

$I->fillField('name', $name);
$I->fillField('email', $email);
$I->fillField('message', $message);
$I->click('Submit');
$I->seeElement('.alert-success');