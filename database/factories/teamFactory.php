<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\team;
use Faker\Generator as Faker;

$factory->define(team::class, function (Faker $faker) {

    return [
        'title' => $faker->text,
        'name' => $faker->text,
        'email' => $faker->text,
        'password' => $faker->text,
        'contact_number' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
