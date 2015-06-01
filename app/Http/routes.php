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

/*
|--------------------------------------------------------------------------
| Textbook Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware'=>'auth', 'prefix'=>'textbook'], function() {
    Route::get('/', 'TextbookController@index');
    Route::get('/buy', 'TextbookController@buy');
    Route::get('/sell', 'TextbookController@sell');
    Route::get('/sell/create', 'TextbookController@create');
    Route::post('/sell/search', 'TextbookController@isbnSearch');
    Route::post('/sell/store', 'TextbookController@store');
});

Route::group(['middleware'=>'auth', 'prefix'=>'order'], function()
{
    Route::get('/', 'OrderController@index');
    Route::get('/create/{id}', 'OrderController@create');
    Route::post('/store', 'OrderController@store');
    Route::get('/show/{id}', 'OrderController@index');
    Route::get('/edit/{id}', 'OrderController@edit');
    Route::post('/update/{id}', 'OrderController@update');
});

Route::group(['middleware'=>'auth', 'prefix'=>'cart'], function()
{
    Route::get('/', 'CartController@index');
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

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

