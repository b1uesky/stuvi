<?php
namespace Step\Functional;

class Textbook extends \FunctionalTester
{

    public function buyTextbook($product_id, $payment_method)
    {
        $I = $this;
        $I->amOnPage('/textbook/buy/product/'.$product_id);
        $I->click('Add to cart');
        $I->seeCurrentUrlEquals('/cart');
        $I->click('Proceed to checkout');
        $I->seeCurrentUrlEquals('/order/create');
        $I->fillField('input[name="payment_method"]', $payment_method);
        $I->click('Place your order');
        $I->seeCurrentUrlEquals('/order/confirmation');
    }

    public function schedulePickup($scheduled_pickup_time)
    {
        $I = $this;
        $I->amOnPage('/order/seller');
        $I->click('Update pickup details');
        $I->see('Schedule pickup');
        $I->fillField('input[name="scheduled_pickup_time"]', $scheduled_pickup_time);
        $I->click('Update pickup details');
        $I->seeCurrentUrlEquals('/order/seller');
        $I->seeElement('.alert-success');
    }

    public function pickup($seller_order)
    {
        $I = $this;
        $I->amOnPage('/express/pickup/'.$seller_order->id);
        $I->see('Ready to pick up');
        $I->click('Ready to pick up');
        $I->seeElement('input[name="code"]');
        $I->fillField('input[name="code"]', $seller_order->pickup_code);
        $I->click('Confirm pickup');
        $I->see('The textbook has been picked up.');
    }

    public function scheduleDelivery($scheduled_delivery_time)
    {
        $I = $this;
        $I->amOnPage('/order/buyer');
        $I->click('Update delivery details');
        $I->see('Schedule delivery');
        $I->fillField('input[name="scheduled_delivery_time"]', $scheduled_delivery_time);
        $I->click('Update delivery details');
        $I->seeCurrentUrlEquals('/order/buyer');
        $I->seeElement('.alert-success');
    }

    public function deliver($buyer_order)
    {
        $I = $this;
        $I->amOnPage('/express/deliver/'.$buyer_order->id);
        $I->see('Ready to ship!');
        $I->click('Ready to ship!');
        $I->seeElement('input[name="delivery_code"]');
        $I->fillField('input[name="delivery_code"]', $buyer_order->delivery_code);
        $I->click('Confirm delivery');
        $I->see('The textbook has been delivered');
    }

}