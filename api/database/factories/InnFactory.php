<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;


$factory->define(\App\Models\Inn::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'owner_id' => \App\Models\Owner::all()->random()->id,
        'water_price' => $faker->randomDigit,
        'electric_price' => $faker->randomDigit,
        'open_hour' => $faker->numberBetween(0, 23),
        'open_minute' => $faker->numberBetween(0, 59),
        'close_hour' => $faker->numberBetween(0, 23),
        'close_minute' => $faker->numberBetween(0, 23),
        'description' => $faker->text,
        'address' => $faker->address,
        'location' => null,
        'status' => $faker->randomDigit
    ];
});
