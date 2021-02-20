<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;


$factory->define(\App\Models\Inn::class, function (Faker $faker) {
    return [
        //
        'id' => $faker->unique()->numberBetween(1,30),
        'name' => $faker->name,
        'owner_id' => \App\Models\Owner::all()->random()->id,
        'water_price' => $faker->randomDigit,
        'electric_price' => $faker->randomDigit,
        'description' => $faker->text,
        'address' => $faker->address,
        'location' => null,
        'status' => $faker->randomDigit,
        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
    ];
});
