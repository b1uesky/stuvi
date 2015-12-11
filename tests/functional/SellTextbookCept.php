<?php
$I = new FunctionalTester($scenario);
$I->wantTo('sell a textbook');
$I->amLoggedAs(\App\User::find(3));
$I->amOnPage('/textbook/search?query=');
$I->click('Sell');
$I->see('Sell your book');
//$I->selectOption('input[name="general_condition"]', 0);
//$I->selectOption('input[name="highlights_and_notes"]', 0);
//$I->selectOption('input[name="damaged_pages"]', 0);
//$I->selectOption('input[name="broken_binding"]', 0);
//$I->attachFile('.dz-hidden-input', 'test.jpg');
//$I->submitForm('#form-create-product', [
//    'general_condition'     => 0,
//    'highlights_and_notes'  => 0,
//    'damaged_pages'         => 0,
//    'broken_binding'        => false,
//    'description'           => '',
//    'file'  => '',
//    'available_at'          => \Carbon\Carbon::today(),
//    'price'                 => 25,
//    'payout_method'         => 'paypal',
//    'paypal'                => 'seller@stuvi.com'
//]);
//$I->see('Details');