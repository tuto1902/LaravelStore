<?php

use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'description' => $faker->text(),
        'price' => $faker->numberBetween(1099, 2999)
    ];
});
