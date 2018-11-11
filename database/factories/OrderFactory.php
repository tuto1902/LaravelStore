<?php

use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'total' => 1099
    ];
});
