<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\OwnerContact::class, function (Faker $faker) {
    return [
        //
        'owner_id' => \App\Models\Owner::all()->random()->id,
        'contact_type_id' => \App\Models\MstContactType::all()->random()->id,
        'content' => $faker->text
    ];
});
