<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\plans;
use Faker\Generator as Faker;

$factory->define(plans::class, function (Faker $faker) {

    return [
        'title' => $faker->text,
        'decsription' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
