<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\RoomGender::class, function (Faker $faker) {
    return [
        //
        'room_id' => \App\Models\Room::all()->random()->id,
        'gender_type_id' => \App\Models\MstGenderType::all()->random()->id
    ];
});
