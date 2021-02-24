<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\InnFeature::class, function (Faker $faker) {
    return [
        //
        'id' => $faker->unique()->numberBetween(1, 30),
        'inn_id' => \App\Models\Inn::all()->random()->id,
        'inn_feature_id' => \App\Models\MstFeatureType::all()->random()->id,
        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
    ];
});
