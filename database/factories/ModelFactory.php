<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'password'      => bcrypt($faker->password(6)),
        'phone_number'  => '8572655018',
        'university_id' => 1,
        'role'          => 'u'
    ];
});

$factory->define(App\Email::class, function (Faker\Generator $faker) {
    return [
        'user_id'       => null,
        'email_address' => $faker->firstName.'@bu.edu'
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'book_id'           => \App\Book::orderByRaw('RAND()')->first()->id,
        'seller_id'         => \App\User::orderByRaw('RAND()')->first()->id,
        'price'             => $faker->numberBetween(1, 1000),
        'available_at'      => $faker->date(),
        'payout_method'     => $faker->randomElement(['cash', 'paypal']),
        'accept_trade_in'   => $faker->boolean(),
        'verified'          => true
    ];
});

$factory->define(App\ProductCondition::class, function (Faker\Generator $faker) {
    return [
        'product_id'            => null,
        'general_condition'     => $faker->numberBetween(0, 2),
        'highlights_and_notes'  => $faker->numberBetween(0, 2),
        'damaged_pages'         => $faker->numberBetween(0, 2),
        'broken_binding'        => $faker->boolean(),
        'description'           => $faker->paragraph()
    ];
});

$factory->define(App\ProductImage::class, function (Faker\Generator $faker) {
    return [
        'product_id'    => null,
        'small_image'   => $faker->imageUrl(),
        'medium_image'  => $faker->imageUrl(),
        'large_image'   => $faker->imageUrl()
    ];
});
