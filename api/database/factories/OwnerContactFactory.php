<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\OwnerContact::class, function (Faker $faker) {
    return [
        //
        'id' => $faker->unique()->numberBetween(1, 30),
        'owner_id' => \App\Models\Owner::all()->random()->id,
        'contact_type_id' => \App\Models\MstContactType::all()->random()->id,
        'content' => $faker->text,
        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
    ];
});
