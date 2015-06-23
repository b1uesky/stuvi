<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/login', 'HomeController@login');
Route::get('/register', 'HomeController@register');
Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');

/*
|--------------------------------------------------------------------------
| Textbook Routes
|--------------------------------------------------------------------------
*/

// textbook
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'textbook'], function() {
    Route::get('/', 'TextbookController@index');

    // buy
    Route::group(['prefix'=>'buy'], function() {
        Route::get('/', 'TextbookController@showBuyPage');
        Route::get('/textbook/{book}', 'TextbookController@show');
        Route::get('/product/{product}', 'ProductController@show');
        Route::post('/search', 'TextbookController@buySearch');
    });

    // sell
    Route::group(['prefix'=>'sell'], function() {
        Route::get('/', 'TextbookController@sell');
        Route::get('/create', 'TextbookController@create');
        Route::get('/product/create/{book}', 'ProductController@create');
        Route::post('/search', 'TextbookController@sellSearch');
        Route::post('/store', 'TextbookController@store');
        Route::post('/product/store', 'ProductController@store');
    });

});

// order
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'order'], function()
{

    Route::get('/buyer', 'BuyerOrderController@buyerOrderIndex');
    Route::get('/confirmation', 'BuyerOrderController@confirmation');
    Route::get('/create', 'BuyerOrderController@createBuyerOrder');
    Route::post('/store', 'BuyerOrderController@storeBuyerOrder');
    Route::get('/buyer/{id}', 'BuyerOrderController@showBuyerOrder');
    Route::get('/buyer/cancel/{id}', 'BuyerOrderController@cancelBuyerOrder');

    Route::get('/seller', 'SellerOrderController@sellerOrderIndex');
    Route::get('/seller/cancel/{id}', 'SellerOrderController@cancelSellerOrder');
    Route::post('/seller/setscheduledtime', 'SellerOrderController@setScheduledPickupTime');
    Route::get('/seller/{id}', 'SellerOrderController@showSellerOrder');
});

// cart
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'cart'], function()
{
    Route::get('/', 'CartController@index');
    Route::get('add/{id}', 'CartController@addItem');
    Route::get('rmv/{id}', 'CartController@removeItem');
    Route::get('empty', 'CartController@emptyCart');
});

/*
|--------------------------------------------------------------------------
| Housing Routes
|--------------------------------------------------------------------------
*/
//Route::get('/housing', 'HousingController@index');

/*
|--------------------------------------------------------------------------
| Club Routes
|--------------------------------------------------------------------------
*/
//Route::get('/club', 'ClubController@index');

/*
|--------------------------------------------------------------------------
| Group Routes
|--------------------------------------------------------------------------
*/
//Route::get('/group', 'GroupController@index');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware'=>'auth', 'prefix'=>'user'], function()
{
    Route::get('/profile', 'UserController@profile');
    Route::get('/profile-edit', 'UserController@profileEdit');
    Route::get('/account', 'UserController@account');
    Route::post('/account/edit', 'UserController@edit');
    Route::get('/bookshelf', 'UserController@bookshelf');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group(['namespace'=>'Admin', 'middleware'=>['auth', 'role:a'], 'prefix'=>'admin'], function()
{
    Route::get('/', 'AdminController@index');

    // user
    Route::resource('user', 'UserController');

    // product
    Route::get('/product/verified', 'ProductController@showVerified');
    Route::get('/product/unverified', 'ProductController@showUnverified');
    Route::get('/product/{id}/approve', 'ProductController@approve');
    Route::get('/product/{id}/disapprove', 'ProductController@disapprove');
    Route::resource('product', 'ProductController');

    // seller order
    Route::resource('sellerOrder', 'SellerOrderController');
});
