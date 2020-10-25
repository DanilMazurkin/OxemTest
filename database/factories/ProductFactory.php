<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'external_id' => $faker->randomDigit(), 
        'describe' => $faker->realText($maxNbChars = 200, $indexSize = 2), 
        'name' => $faker->name, 
        'price' => $faker->randomFloat(NULL, 0, 1000), 
        'quantity' => $faker->randomDigit(), 
        'created_on' => $faker->dateTimeBetween('-3 months','-2 months')
    ];
});
