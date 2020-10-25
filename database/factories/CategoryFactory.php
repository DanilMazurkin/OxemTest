<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'id_parent_category' => $faker->randomDigit(), 
        'external_id' => $faker->randomDigit()
    ];
});
