<?php
$faker = \Faker\Factory::create();
$profile = [
    'sex'       => $faker->randomElement(['male', 'female']),
    'birth'     => $faker->date(),
    'bio'       => $faker->paragraph(),
    'major'     => $faker->word,
    'facebook'  => $faker->url,
    'twitter'   => $faker->url,
    'linkedin'  => $faker->url,
    'site'      => $faker->url
];

$I = new FunctionalTester($scenario);
$I->wantTo('update profile settings');

$I->amLoggedAs(\App\User::find(3));
$I->amOnPage('/user/profile');
$I->see('Personal information');

$I->selectOption('sex', $profile['sex']);
$I->fillField('birth', $profile['birth']);
$I->fillField('bio', $profile['bio']);
$I->fillField('major', $profile['major']);
$I->fillField('facebook', $profile['facebook']);
$I->fillField('twitter', $profile['twitter']);
$I->fillField('linkedin', $profile['linkedin']);
$I->fillField('site', $profile['site']);
$I->click('Update Profile');

$I->seeInField('sex', $profile['sex']);
$I->seeInField('birth', $profile['birth']);
$I->seeInField('bio', $profile['bio']);
$I->seeInField('major', $profile['major']);
$I->seeInField('facebook', $profile['facebook']);
$I->seeInField('twitter', $profile['twitter']);
$I->seeInField('linkedin', $profile['linkedin']);
$I->seeInField('site', $profile['site']);