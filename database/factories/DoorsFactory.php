<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Doors;
use Faker\Generator as Faker;

$factory->define(Doors::class, function (Faker $faker) {

    return [
        'doors' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
