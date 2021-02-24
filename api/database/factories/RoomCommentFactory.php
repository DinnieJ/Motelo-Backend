<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\RoomComment::class, function (Faker $faker) {
    return [
        //
        'id' => $faker->unique()->numberBetween(1, 30),
        'tenant_id' => \App\Models\Tenant::all()->random()->id,
        'room_id' => \App\Models\Room::all()->random()->id,
        'comment' => $faker->text,
        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
    ];
});
