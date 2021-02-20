<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Owner::class, function (Faker $faker) {
    return [
        //
        'id' => $faker->unique()->numberBetween(1, 30),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('abcxyz'),
        'address' => $faker->address,
        'date_of_birth' => $faker->date('Y-m-d'),
        'enabled' => 1,
        'remember_token' => null,
        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')


    ];
});
