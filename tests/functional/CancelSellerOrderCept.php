<?php
use Step\Functional\Textbook as FunctionalTester;
// INCOMPLETE
// TODO: migrate this test to acceptance test since js modal is involved.
// Since the cancel action is a post request, we have no way to
// interact with js modal.

$buyer = \App\User::find(4);
$product = \App\Product::where('sold', false)
    ->where('verified', true)
    ->whereNull('deleted_at')
    ->where('seller_id', '!=', $buyer->id)
    ->first();
$seller = \App\User::find($product->seller_id);

$I = new FunctionalTester($scenario);
$I->wantTo('cancel my seller order after my book was sold');

// login as a buyer and buy a textbook
$I->amLoggedAs($buyer);
$I->buyTextbook($product->id, 'cash');

$seller_order = \App\SellerOrder::orderBy('created_at', 'desc')->first();

// login as the book seller and cancel the seller order
$I->amLoggedAs($seller);

$I->amOnPage('/order/seller/'.$seller_order->id);
//$I->seeElement('.alert-success');
//$I->see('Order cancelled');