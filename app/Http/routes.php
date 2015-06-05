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
        Route::post('/search', 'TextbookController@isbnSearch');
        Route::post('/store', 'TextbookController@store');
        Route::post('/product/store', 'ProductController@store');
    });

});

// order
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'order'], function()
{
    Route::get('/', 'OrderController@index');
    Route::get('/create', 'OrderController@createBuyerOrder');
    Route::post('/store', 'OrderController@storeBuyerOrder');
    Route::get('/{id}', 'OrderController@showBuyerOrder');
    Route::get('/cancel/{id}', 'OrderController@cancelBuyerOrder');
    Route::get('/edit/{id}', 'OrderController@edit');
    Route::post('/update/{id}', 'OrderController@update');
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
Route::get('/housing', 'HousingController@index');

/*
|--------------------------------------------------------------------------
| Club Routes
|--------------------------------------------------------------------------
*/
Route::get('/club', 'ClubController@index');

/*
|--------------------------------------------------------------------------
| Group Routes
|--------------------------------------------------------------------------
*/
Route::get('/group', 'GroupController@index');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::get('/user/profile', 'UserController@profile');
Route::get('/user/account', 'UserController@account');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
