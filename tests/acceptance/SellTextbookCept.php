<?php
$scenario->incomplete();

$I = new AcceptanceTester($scenario);
$I->wantTo('sell a textbook');

//$I->login('seller@bu.edu', '123456');
$I->amOnPage('/textbook/sell/product/25/create');
$I->see('Sell your book');
//
//$I->submitForm('#form-create-product', [
//    'general_condition'     => 0,
//    'highlights_and_notes'  => 0,
//    'damaged_pages'         => 0,
//    'broken_binding'        => false,
//    'description'           => '',
//    'file'                  => [
//        codecept_data_dir('test.jpg')
//    ],
//    'available_at'          => \Carbon\Carbon::today(),
//    'price'                 => 25,
//    'payout_method'         => 'paypal',
//    'paypal'                => 'seller@stuvi.com',
//    'accept_trade_in'       => true
//]);
//$I->see('Details');

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