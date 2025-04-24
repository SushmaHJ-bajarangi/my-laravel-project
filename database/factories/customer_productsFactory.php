<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\customer_products;
use Faker\Generator as Faker;

$factory->define(customer_products::class, function (Faker $faker) {

    return [
        'customer_id' => $faker->text,
        'model_id' => $faker->text,
        'door' => $faker->text,
        'number_of_floors' => $faker->text,
        'cop_type' => $faker->text,
        'lop_type' => $faker->text,
        'passenger_capacity' => $faker->text,
        'distance' => $faker->text,
        'unique_job_number' => $faker->text,
        'warranty_start_date' => $faker->text,
        'warranty_end_date' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
