<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\parts;
use Faker\Generator as Faker;

$factory->define(parts::class, function (Faker $faker) {

    return [
        'title' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
