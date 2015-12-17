<?php
use Step\Functional\Textbook as FunctionalTester;

$buyer = \App\User::find(4);
$product = \App\Product::where('sold', false)
    ->where('verified', true)
    ->whereNull('deleted_at')
    ->where('seller_id', '!=', $buyer->id)
    ->first();
$seller = \App\User::find($product->seller_id);
$courier = \App\User::find(5);

$I = new FunctionalTester($scenario);
$I->wantTo('buy a textbook with cash');

// login as a buyer and buy a textbook
$I->amLoggedAs($buyer);
$I->buyTextbook($product->id, 'cash');

// login as the book seller and schedule a pickup
$I->amLoggedAs($seller);
$I->schedulePickup(\Carbon\Carbon::now()->addHours(2));

$seller_order = \App\SellerOrder::orderBy('created_at', 'desc')->first();

// login as the courier and pickup the seller order
$I->amLoggedAs($courier);
$I->pickup($seller_order);

// login as the buyer and schedule a delivery
$I->amLoggedAs($buyer);
$I->scheduleDelivery(\Carbon\Carbon::tomorrow());

$buyer_order = \App\BuyerOrder::orderBy('created_at', 'desc')->first();

// login as the courier and deliver the book
$I->amLoggedAs($courier);
$I->deliver($buyer_order);