<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('sell a book');
$I->amLoggedAs(\App\User::find(1));
$I->amOnPage('/textbook/search?query=');
$I->click('Sell');
$I->see('Sell your book');
