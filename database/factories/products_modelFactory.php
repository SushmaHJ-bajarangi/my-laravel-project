<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\products_model;
use Faker\Generator as Faker;

$factory->define(products_model::class, function (Faker $faker) {

    return [
        'title' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
