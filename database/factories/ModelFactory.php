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