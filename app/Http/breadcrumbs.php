<?php namespace App\Http;

use App\BuyerOrder;
use Breadcrumbs;

Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', url('/home'));
});

Breadcrumbs::register('buyerOrders',function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Order',url('/order/buyer'));
});

Breadcrumbs::register('buyerOrderDetail', function ($breadcrumbs,$id) {
    $orderDetailPage = BuyerOrder::findOrFail($id);
    $breadcrumbs->parent('buyerOrders');
    $breadcrumbs->push('Order Details',url('/order/buyer/',[$orderDetailPage->id]));
});