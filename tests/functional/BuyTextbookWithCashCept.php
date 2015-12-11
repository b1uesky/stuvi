<?php
$I = new FunctionalTester($scenario);
$I->wantTo('buy a textbook with cash');
$I->amLoggedAs(\App\User::find(4));

$product = \App\Product::where('sold', false)
    ->where('verified', true)
    ->whereNull('deleted_at')
    ->where('seller_id', '!=', 4)
    ->first();

$I->amOnAction('Textbook\CartController@addItem', $product->id);
$I->amOnPage('/cart');
$I->click('Proceed to checkout');
$I->seeCurrentUrlEquals('/order/create');
$I->fillField('input[name="payment_method"]', 'cash');
$I->click('Place your order');
$I->seeCurrentUrlEquals('/order/confirmation');