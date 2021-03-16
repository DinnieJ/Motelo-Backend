<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Collaborator::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \bcrypt('12345678'),
        'phone_number' => $faker->phoneNumber,
        'address' => $faker->address,
        'date_of_birth' => $faker->date('Y-m-d'),
        'identity_number' => $faker->randomNumber(9),
        'enabled' => 1
    ];
});
