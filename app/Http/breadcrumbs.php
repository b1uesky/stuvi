<?php namespace App\Http;

use App\BuyerOrder;
use App\SellerOrder;
use Breadcrumbs;

//Breadcrumbs::register('home', function($breadcrumbs) {
//    $breadcrumbs->push('Home', url('/home'));
//});

Breadcrumbs::register('buyerOrders', function($breadcrumbs) {
    $breadcrumbs->push('Your Orders', url('/order/buyer'));
});

Breadcrumbs::register('buyerOrderDetail', function ($breadcrumbs, $id) {
    $orderDetailPage = BuyerOrder::findOrFail($id);
    $breadcrumbs->parent('buyerOrders');
    $breadcrumbs->push('Order Details', url('/order/buyer/', [$orderDetailPage->id]));
});

Breadcrumbs::register('sellerOrders', function($breadcrumbs) {
    $breadcrumbs->push('Your Sold Books', url('/order/seller'));
});

Breadcrumbs::register('sellerOrderDetail', function ($breadcrumbs, $id) {
    $orderDetailPage = SellerOrder::findOrFail($id);
    $breadcrumbs->parent('sellerOrders');
    $breadcrumbs->push('Order Details', url('/order/seller/', [$orderDetailPage->id]));
});