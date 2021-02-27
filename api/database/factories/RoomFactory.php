<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Room::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'inn_id' => \App\Models\Inn::all()->random()->id,
        'room_type_id' => \App\Models\MstRoomType::all()->random()->id,
        'price' => $faker->randomDigit,
        'acreage' => $faker->randomDigit,
        'description' => $faker->text,
        'verified' => true,
        'verified_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'available' => 1,
        'status' => $faker->randomDigit,
        'gender_type_id' => \App\Models\MstGenderType::all()->random()->id
    ];
});
