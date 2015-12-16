<?php
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

// login as a buyer
$I->amLoggedAs($buyer);

// add an item to cart
$I->amOnPage('/textbook/buy/product/'.$product->id);
$I->click('Add to cart');

// on cart page
$I->seeCurrentUrlEquals('/cart');
$I->click('Proceed to checkout');

// on checkout page
$I->seeCurrentUrlEquals('/order/create');
$I->fillField('input[name="payment_method"]', 'cash');
$I->click('Place your order');

// order complete
$I->seeCurrentUrlEquals('/order/confirmation');

$I->seeRecord('products', [
    'id'    => $product->id,
    'sold'  => true
]);
$I->seeRecord('buyer_orders', [
    'buyer_id'          => $buyer->id,
    'payment_method'    => 'cash'
]);
$I->seeRecord('seller_orders', [
    'product_id'   => $product->id,
]);

// login as the book seller
$I->amLoggedAs($seller);

// on sold books page
$I->amOnPage('/order/seller');
$I->click('Update pickup details');

// on schedule pickup page
$I->see('Schedule pickup');
$I->fillField('input[name="scheduled_pickup_time"]', \Carbon\Carbon::now()->addHours(2));
$I->click('Update pickup details');
$I->seeCurrentUrlEquals('/order/seller');
$I->seeElement('.alert-success');

$seller_order = \App\SellerOrder::orderBy('created_at', 'desc')->first();

// login as the courier
$I->amLoggedAs($courier);

// ready to pickup
$I->amOnPage('/express/pickup/'.$seller_order->id);
$I->see('Ready to pick up');
$I->click('Ready to pick up');

// confirm pickup
$I->seeElement('input[name="code"]');
$I->fillField('input[name="code"]', $seller_order->pickup_code);
$I->click('Confirm pickup');
$I->see('The textbook has been picked up.');

// login as the buyer
$I->amLoggedAs($buyer);
$I->amOnPage('/order/buyer');
$I->click('Update delivery details');

// schedule a delivery
$I->see('Schedule delivery');
$I->fillField('input[name="scheduled_delivery_time"]', \Carbon\Carbon::tomorrow());
$I->click('Update delivery details');
$I->seeCurrentUrlEquals('/order/buyer');
$I->seeElement('.alert-success');

$buyer_order = \App\BuyerOrder::orderBy('created_at', 'desc')->first();

// login as the courier
$I->amLoggedAs($courier);

// ready to ship
$I->amOnPage('/express/deliver/'.$buyer_order->id);
$I->see('Ready to ship!');
$I->click('Ready to ship!');

// confirm delivery
$I->seeElement('input[name="delivery_code"]');
$I->fillField('input[name="delivery_code"]', $buyer_order->delivery_code);
$I->click('Confirm delivery');
$I->see('The textbook has been delivered');