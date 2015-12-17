<?php
use Step\Functional\Textbook as FunctionalTester;
// After we figure out how to run acceptance test without problem, we should
// migrate this test to acceptance test since js modal is involved.

$buyer = \App\User::find(4);
$product = \App\Product::where('sold', false)
    ->where('verified', true)
    ->whereNull('deleted_at')
    ->where('seller_id', '!=', $buyer->id)
    ->first();

$I = new FunctionalTester($scenario);
$I->wantTo('cancel my order after buy a textbook');

// login as a buyer and buy a textbook
$I->amLoggedAs($buyer);
$I->buyTextbook($product->id, 'cash');

$buyer_order = \App\BuyerOrder::orderBy('created_at', 'desc')->first();

// cancel order
$I->click('View order details');
// We are supposed to click cancel order button in the popup modal like this:
// $I->click('Cancel order', '#cancel-buyer-order');
// But we cannot interact with js in functional test, so action is used here.
$I->amOnAction('Textbook\BuyerOrderController@cancel', [$buyer_order]);
$I->seeElement('.alert-success');
$I->see('Order cancelled');