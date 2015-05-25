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
Route::get('/textbook', 'TextbookController@index');
Route::get('/textbook/buy', 'TextbookController@buy');
Route::get('/textbook/sell', 'TextbookController@sell');
Route::get('/textbook/sell/create', 'TextbookController@create');
Route::post('/textbook/sell/search', 'TextbookController@search');
Route::post('/textbook/sell/store', 'TextbookController@store');

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

Route::group(['middleware'=>'auth', 'prefix'=>'order'], function()
{
    Route::get('/', 'OrderController@index');
    Route::get('/create/{id}', 'OrderController@create');
    Route::post('/store', 'OrderController@store');
    Route::get('/show/{id}', 'OrderController@index');
    Route::get('/edit/{id}', 'OrderController@edit');
    Route::post('/update/{id}', 'OrderController@update');
});
