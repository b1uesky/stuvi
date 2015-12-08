<?php

$I = new AcceptanceTester($scenario);
//$I->login();
$I->wantTo('post a book');
$I->amOnPage('/textbook/sell/product/2/create');

$I->see('Sell your book');

//$I->selectOption('general_condition', 0);
//$I->selectOption('highlights_and_notes', 0);
//$I->selectOption('damaged_pages', 0);
//$I->selectOption('broken_binding', 0);
//$I->attachFile('input[type="file"]', 'test.jpg');
//$I->selectOption('available_at', \Carbon\Carbon::today()->toDateString());
//$I->fillField('price', 25);
//$I->selectOption('payout_method', 'cash');
//
//$I->click('Submit');

//$I->submitForm('#form-create-product', [
//    'general_condition' => 0
//]);

