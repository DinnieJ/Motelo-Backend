<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\RoomComment::class, function (Faker $faker) {
    return [
        //
        'tenant_id' => \App\Models\Tenant::all()->random()->id,
        'room_id' => \App\Models\Room::all()->random()->id,
        'comment' => $faker->text
    ];
});
