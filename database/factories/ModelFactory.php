<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'password'      => bcrypt(str_random(6)),
        'phone_number'  => $faker->phoneNumber,
        'university_id' => 1
    ];
});