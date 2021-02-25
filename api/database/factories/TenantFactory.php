<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Tenant::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('abcxyz'),
        'date_of_birth' => $faker->date('Y-m-d'),
        'enabled' => 1,
        'remember_token' => null
    ];
});
