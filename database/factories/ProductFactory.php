<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'external_id' => $faker->randomDigit(), 
        'describe' => $faker->realText($maxNbChars = 200, $indexSize = 2), 
        'name' => $faker->name, 
        'price' => $faker->randomFloat(NULL, 0, 1000), 
        'category_id' => [$faker->randomDigit(), $faker->randomDigit()],  
        'quantity' => $faker->randomDigit(), 
        'created_on' => $faker->dateTimeBetween('-3 months','-2 months')
    ];
});
