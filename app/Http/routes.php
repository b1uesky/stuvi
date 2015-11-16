<?php

Route::pattern('id',            '[0-9]+');
Route::pattern('user',          '[0-9]+');
Route::pattern('book',          '[0-9]+');
Route::pattern('product',       '[0-9]+');
Route::pattern('buyer_order',   '[0-9]+');
Route::pattern('seller_order',  '[0-9]+');
Route::pattern('donation',      '[0-9]+');

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
Route::get  ('/home',       'HomeController@index');
Route::get  ('/about',      'HomeController@about');
Route::get  ('/tos',        'tosPrivacyController@tos');
Route::get  ('/privacy',    'tosPrivacyController@privacy');

/*
|--------------------------------------------------------------------------
| Address Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth', 'prefix' => 'address'],function(){
    Route::post ('/store',  'AddressController@store');
    Route::post ('/update', 'AddressController@update');
    Route::post ('/delete', 'AddressController@delete');
    Route::post ('/select', 'AddressController@select');
});


/*
|--------------------------------------------------------------------------
| Textbook Routes
|--------------------------------------------------------------------------
*/

// auth not required
Route::group(['namespace'=>'Textbook', 'prefix'=>'textbook'], function()
{
    Route::get  ('/',                   'TextbookController@showBuyPage');
    Route::get  ('/search',             'TextbookController@search');
    Route::get  ('/searchAutoComplete', 'TextbookController@searchAutoComplete');
    Route::post ('/validateISBN',       'TextbookController@validateISBN');
    Route::get  ('/confirm/{book}',     'TextbookController@confirm');

    // buy
    Route::group(['prefix'=>'buy'], function() {
        Route::get  ('/{book}',             'TextbookController@show');
        Route::get  ('/product/{product}',  'ProductController@show');
    });

    // sell
    Route::group(['prefix'=>'sell'], function() {
        Route::get  ('/create',                 'TextbookController@create');
    });
});

// auth required
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'textbook'], function() {

    // sell
    Route::group(['prefix'=>'sell'], function() {
        Route::post ('/store',                          'TextbookController@store');
        Route::get  ('/product/{book}/create',          'ProductController@create');
        Route::post ('/product/store',                  'ProductController@store');
        Route::get  ('/product/{product}/edit',         'ProductController@edit');
        Route::get  ('/product/getImages',              'ProductController@getImages');
        Route::post ('/product/deleteImage',            'ProductController@deleteImage');
        Route::post ('/product/update',                 'ProductController@update');
        Route::post ('/product/delete',                 'ProductController@destroy');
        Route::post ('/product/joinTradeIn',            'ProductController@joinTradeIn');
    });

    // donate
    Route::group(['prefix'=>'donate'], function() {
        Route::get  ('/',                       'DonationController@index');
        Route::post ('/store',                  'DonationController@store');
        Route::get  ('{donation}/confirmation', 'DonationController@confirmation');
    });
});

// order
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'order'], function()
{
    // buyer order
    Route::get  ('/buyer',                                  'BuyerOrderController@index');
    Route::get  ('/confirmation',                           'BuyerOrderController@confirmation');
    Route::get  ('/executePayment',                         'BuyerOrderController@executePayment');
    Route::get  ('/create',                                 'BuyerOrderController@create');
    Route::post ('/store',                                  'BuyerOrderController@store');
    Route::get  ('/buyer/{buyer_order}',                    'BuyerOrderController@show');
    Route::get  ('/buyer/cancel/{buyer_order}',             'BuyerOrderController@cancel');
    Route::get  ('/buyer/{buyer_order}/scheduleDelivery',   'BuyerOrderController@scheduleDelivery');
    Route::post ('/buyer/{buyer_order}/confirmDelivery',    'BuyerOrderController@confirmDelivery');

    // seller order
    Route::get  ('/seller',                                 'SellerOrderController@index');
    Route::get  ('/seller/{seller_order}',                  'SellerOrderController@show');
    Route::get  ('/seller/{seller_order}/schedulePickup',   'SellerOrderController@schedulePickup');
    Route::post ('/seller/{seller_order}/confirmPickup',    'SellerOrderController@confirmPickup');
    Route::post ('/seller/{seller_order}/payout',           'SellerOrderController@payout');
    Route::post ('/seller/cancel',                          'SellerOrderController@cancel');
});

// cart
Route::group(['namespace'=>'Textbook', 'middleware'=>'auth', 'prefix'=>'cart'], function()
{
    Route::get('/',         'CartController@index');
    Route::post('/add/{id}','CartController@addItem');
    Route::post('/add',     'CartController@addItemAjax');
    Route::get('/rmv/{id}', 'CartController@removeItem');
    Route::post('/rmv',     'CartController@removeItemAjax');
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
    Route::get ('/overview',                'UserController@overview');
    Route::get ('/profile',                 'ProfileController@index');
    Route::post('/profile/update',          'ProfileController@update');
    Route::get ('/account',                 'AccountController@index');
    Route::post('/account/password/reset',  'AccountController@passwordReset');
    Route::get ('/bookshelf',               'UserController@bookshelf');
    Route::get ('/activate',                'UserController@waitForActivation');
    Route::get ('/activate/resend',         'UserController@resendActivationEmail');
    Route::get ('/activate/{code}',         'UserController@activateAccount');
    Route::get ('/activated',               'UserController@activated');
    Route::post('/updateDefaultAddress',    'UserController@updateDefaultAddress');

    Route::group(['prefix'=>'email'], function()
    {
        Route::get ('/',                    'EmailController@index');
        Route::post('/add',                 'EmailController@store');
        Route::post('/remove',              'EmailController@destroy');
        Route::post('/primary',             'EmailController@setPrimary');
        Route::get ('/{id}/verify/{code}',  'EmailController@verify');
    });

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

    // book
    Route::resource('book', 'BookController');

    // product
    Route::get('/product/verified',                     'ProductController@showVerified');
    Route::get('/product/unverified',                   'ProductController@showUnverified');
    Route::get('/product/{id}/approve',                 'ProductController@approve');
    Route::get('/product/{id}/disapprove',              'ProductController@disapprove');
    Route::post('/product/{id}/updatePriceAndApprove',  'ProductController@updatePriceAndApprove');
    Route::post('/product/{id}/reject',                 'ProductController@reject');
    Route::post('/product/{id}/accept',                 'ProductController@accept');

    Route::resource('product', 'ProductController');

    // seller order
    Route::group(['prefix'=>'order/seller'], function()
    {
        Route::get  ('/',       'SellerOrderController@index');
        Route::get  ('/{id}',   'SellerOrderController@show');
    });

    // buyer order
    Route::group(['prefix'=>'order/buyer'], function()
    {
        Route::get  ('/',       'BuyerOrderController@index');
        Route::get  ('/{id}',   'BuyerOrderController@show');
        Route::post ('/refund', 'BuyerOrderController@refund');
    });

    // buyer payment
    Route::resource('buyer/payment', 'BuyerPaymentController');

    // donation
    Route::resource('donation', 'DonationController');

    // contact
//    Route::post('contact/reply','ContactController@reply');
//    Route::resource('contact',  'ContactController');
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
    Route::get('/pickup',                               'PickupController@index');
    Route::get('/pickup/todo',                          'PickupController@indexTodo');
    Route::get('/pickup/pickedUp',                      'PickupController@indexPickedUp');
    Route::get('/pickup/{id}',                          'PickupController@show');
    Route::get('/pickup/{id}/readyToPickUp',            'PickupController@readyToPickUp');
    Route::post('/pickup/{id}/confirm',                 'PickupController@confirmPickup');
    Route::get('/pickup/donation/{id}',                 'PickupController@showDonation');
    Route::get('/pickup/donation/{id}/readyToPickUp',   'PickupController@readyToPickUpDonation');
    Route::post('/pickup/donation/{id}/confirm',        'PickupController@confirmPickupDonation');

    // deliver
    Route::get('/deliver',                      'DeliverController@index');
    Route::get('/deliver/todo',                 'DeliverController@indexTodo');
    Route::get('/deliver/delivered',            'DeliverController@indexDelivered');
    Route::get('/deliver/{id}',                 'DeliverController@show');
    Route::get('/deliver/{id}/readyToShip',     'DeliverController@readyToShip');
    Route::post('/deliver/{id}/confirmDelivery', 'DeliverController@confirmDelivery');
});

/*
|--------------------------------------------------------------------------
| FAQ Routes
|--------------------------------------------------------------------------
*/

Route::get('/faq',          'FAQController@general');
Route::get('/faq/general',  'FAQController@general');
Route::get('/faq/orders',   'FAQController@orders');
Route::get('/faq/account',  'FAQController@account');
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
| Testing Routes
|--------------------------------------------------------------------------
*/
Route::get('/test', function()
{
    $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
    $beautymail->send('emails.test', [], function($message)
    {
        $message
            ->from('bar@example.com')
            ->to('foo@example.com', 'John Smith')
            ->subject('Welcome!');
    });

});
