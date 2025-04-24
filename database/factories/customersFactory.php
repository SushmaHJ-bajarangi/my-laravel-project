<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\customers;
use Faker\Generator as Faker;

$factory->define(customers::class, function (Faker $faker) {

    return [
        'name' => $faker->text,
        'email' => $faker->text,
        'password' => $faker->text,
        'authorized_person_name' => $faker->text,
        'contact_number' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
