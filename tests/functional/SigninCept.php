<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('log in as regular user');
$I->amOnPage('/auth/login');
$I->fillField('email', 'seller@bu.edu');
$I->fillField('password', '123456');
$I->click('#login-body button[type="submit"]');
$I->see('Welcome to Stuvi');
