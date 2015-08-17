<?php

/*
|--------------------------------------------------------------------------
| Route Patterns
|--------------------------------------------------------------------------
| Define some route parameter patterns so they won't confuse with other routes, e.g.,
| Route::get('/{book}', 'TextbookController@show');
| Route::get('/searchAutoComplete', 'TextbookController@buySearchAutoComplete');
|
 */
Route::pattern('id',        '[0-9]+');
Route::pattern('book',      '[0-9]+');
Route::pattern('product',   '[0-9]+');

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

Route::get  ('/',           'HomeController@index');
Route::get  ('/home',       ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get  ('/about',      'HomeController@about');
Route::get  ('/coming',     'HomeController@coming');

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
    Route::get('/activate', 'UserController@waitForActivation');
    Route::get('/activate/resend', 'UserController@resendActivationEmail');
    Route::get('/activate/{code}', 'UserController@activateAccount');
    Route::post('/updateDefaultAddress', 'UserController@updateDefaultAddress');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/*
|--------------------------------------------------------------------------
| Address Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth', 'prefix' => 'address'],function(){
    Route::post ('/store','AddressController@store');
    Route::post ('/update','AddressController@update');
    Route::post ('/delete','AddressController@ajaxDelete');
    Route::post ('/select','AddressController@ajaxSelect');
    Route::get  ('/show',  'AddressController@show');
});


/*
|--------------------------------------------------------------------------
| Textbook Routes
|--------------------------------------------------------------------------
*/

// auth not required
Route::group(['namespace'=>'Textbook', 'prefix'=>'textbook'], function()
{
    Route::get  ('/',   'TextbookController@showBuyPage');
    Route::get  ('/searchAutoComplete', 'TextbookController@buySearchAutoComplete');
    Route::post ('/validateISBN', 'TextbookController@validateISBN');

    // buy
    Route::group(['prefix'=>'buy'], function() {
        Route::get  ('/', ['as' => 'buyTextbook', 'uses' => 'TextbookController@showBuyPage']);
        Route::get  ('/{book}', 'TextbookController@show');
        Route::get  ('/search', 'TextbookController@buySearch');
        Route::get  ('/product/{product}', 'ProductController@show');
    });

    // sell
    Route::group(['prefix'=>'sell'], function() {
        Route::get  ('/',                       'TextbookController@sell');
        Route::post ('/search',                 'TextbookController@sellSearch');
        Route::get  ('/create',                 'TextbookController@create');
        Route::get  ('/product/{book}/create',  'ProductController@create');
    });
});

// auth required
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'textbook'], function() {

    // sell
    Route::group(['prefix'=>'sell'], function() {
        Route::post ('/store',                  'TextbookController@store');
        Route::post ('/product/store',          'ProductController@store');
        Route::get  ('/product/{id}/edit',      'ProductController@edit');
        Route::get  ('/product/getImages',      'ProductController@getImages');
        Route::post ('/product/deleteImage',    'ProductController@deleteImage');
        Route::post ('/product/update',         'ProductController@update');
        Route::post ('/product/delete',         'ProductController@destroy');
    });

});

// order
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'order'], function()
{
    Route::get  ('/buyer',              ['as' => 'buyerOrders', 'uses' => 'BuyerOrderController@index']);
    Route::get  ('/confirmation',       'BuyerOrderController@confirmation');
    Route::get  ('/executePayment',     'BuyerOrderController@executePayment');
    Route::get  ('/create',             ['as' => 'checkout','uses'=>'BuyerOrderController@create']);
    Route::post ('/store',              'BuyerOrderController@store');
    Route::get  ('/buyer/{id}',         ['as' => 'buyerOrderDetail', 'uses' => 'BuyerOrderController@show']);
    Route::get  ('/buyer/cancel/{id}',  'BuyerOrderController@cancel');

    Route::get  ('/seller',                     ['as' => 'sellerOrders', 'uses' => 'SellerOrderController@index']);
    Route::get  ('/seller/{id}',                ['as' => 'sellerOrderDetail', 'uses' => 'SellerOrderController@show']);
    Route::get  ('/seller/cancel/{id}',         'SellerOrderController@cancel');
    Route::post ('/seller/schedulePickupTime',  'SellerOrderController@schedulePickupTime');
    Route::get  ('/seller/{id}/addAddress',     'SellerOrderController@addAddress');
    Route::get  ('/seller/assignAddress',       'SellerOrderController@assignAddress');
    Route::post ('/seller/storeAddress',        'SellerOrderController@storeAddress');
    Route::get  ('/seller/{id}/confirmPickup',  'SellerOrderController@confirmPickup');
    Route::post ('/seller/transfer',            'SellerOrderController@transfer');
});

// Stripe authorization
Route::group(['middleware'=>'auth', 'prefix'=>'stripe'], function()
{
    Route::get  ('/store', 'StripeAuthorizationCredentialController@store');
});

// cart
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'cart'], function()
{
    Route::get('/',         ['as' => 'shoppingCart', 'uses' => 'CartController@index']);
    Route::get('/add/{id}', 'CartController@addItem');
    Route::get('/rmv/{id}', 'CartController@removeItem');
    Route::get('/rmv',      'CartController@removeItemAjax');
    Route::get('/empty',    'CartController@emptyCart');
    Route::get('/update',   'CartController@updateCart');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::group(['namespace'=>'User', 'middleware'=>'auth', 'prefix'=>'user'], function()
{
    Route::get ('/overview',        'UserController@overview');
    Route::get ('/profile',         'ProfileController@index');
    Route::post('/profile/update',  'ProfileController@update');
    Route::get ('/account',         'AccountController@index');
    Route::post('/account/password/reset',    'AccountController@passwordReset');
    Route::get ('/bookshelf',       'UserController@bookshelf');
    Route::get ('/activate',        'UserController@waitForActivation');
    Route::get ('/activate/resend', 'UserController@resendActivationEmail');
    Route::get ('/activate/{code}', 'UserController@activateAccount');
    Route::post('/updateDefaultAddress', 'UserController@updateDefaultAddress');

    Route::group(['prefix'=>'email'], function()
    {
        Route::get ('/',        'EmailController@index');
        Route::post('/add',     'EmailController@store');
        Route::post('/remove',  'EmailController@destroy');
        Route::post('/primary', 'EmailController@setPrimary');
        Route::get ('/{id}/verify/{code}',  'EmailController@verify');
    });

});

//Route::get ('user/activate',        'UserController@waitForActivation');

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

    // book
    Route::resource('book', 'BookController');

    // product
    Route::get('/product/verified', 'ProductController@showVerified');
    Route::get('/product/unverified', 'ProductController@showUnverified');
    Route::get('/product/{id}/approve', 'ProductController@approve');
    Route::get('/product/{id}/disapprove', 'ProductController@disapprove');
    Route::resource('product', 'ProductController');

    // seller order
    Route::group(['prefix'=>'order/seller'], function()
    {
        Route::get  ('/', 'SellerOrderController@index');
        Route::get  ('/{id}', 'SellerOrderController@show');
    });

    // buyer order
    Route::group(['prefix'=>'order/buyer'], function()
    {
        Route::get  ('/', 'BuyerOrderController@index');
        Route::get  ('/{id}', 'BuyerOrderController@show');
        Route::post ('/refund', 'BuyerOrderController@refund');
    });

    // buyer payment
    Route::resource('buyer/payment', 'BuyerPaymentController');

    // contact
    Route::post('contact/reply', 'ContactController@reply');
    Route::resource('contact', 'ContactController');
});

/*
|--------------------------------------------------------------------------
| Express Routes
|--------------------------------------------------------------------------
*/
Route::group(['namespace'=>'Express', 'middleware'=>['auth', 'role:ac'], 'prefix'=>'express'], function()
{
    Route::get('/', 'PickupController@index');

    // pickup
    Route::get('/pickup', 'PickupController@index');
    Route::get('/pickup/todo', 'PickupController@indexTodo');
    Route::get('/pickup/pickedUp', 'PickupController@indexPickedUp');
    Route::get('/pickup/{id}', 'PickupController@show');
    Route::get('/pickup/{id}/readyToPickUp', 'PickupController@readyToPickUp');
    Route::post('/pickup/{id}/confirm', 'PickupController@confirmPickup');

    // deliver
    Route::get('/deliver', 'DeliverController@index');
    Route::get('/deliver/todo', 'DeliverController@indexTodo');
    Route::get('/deliver/delivered', 'DeliverController@indexDelivered');
    Route::get('/deliver/{id}', 'DeliverController@show');
    Route::get('/deliver/{id}/readyToShip', 'DeliverController@readyToShip');
    Route::get('/deliver/{id}/confirmDelivery', 'DeliverController@confirmDelivery');
});

/*
|--------------------------------------------------------------------------
| FAQ Routes
|--------------------------------------------------------------------------
*/

Route::get('/faq', 'FAQController@general');
Route::get('/faq/general', 'FAQController@general');
Route::get('/faq/orders', 'FAQController@orders');
Route::get('/faq/account', 'FAQController@account');
Route::get('/faq/textbook', 'FAQController@textbook');

/*
|--------------------------------------------------------------------------
| Contacts Routes
|--------------------------------------------------------------------------
*/
Route::get  ('/contact',        'ContactController@index');
Route::post ('/contact/store',  'ContactController@store');

/*
|--------------------------------------------------------------------------
| Sitemap Routes
|--------------------------------------------------------------------------
*/
Route::get  ('/sitemap', 'SitemapController@index');


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