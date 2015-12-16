<?php
$faker = \Faker\Factory::create();
$new_password = $faker->password();

$I = new FunctionalTester($scenario);
$I->wantTo('change password');

$I->amLoggedAs(\App\User::find(3));
$I->amOnPage('/user/account');
$I->see('Change password');

$I->fillField('current_password', '123456');
$I->fillField('new_password', $new_password);
$I->fillField('new_password_confirmation', $new_password);
$I->click('Update password');
$I->seeElement('.alert-success');