<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\InnFeature::class, function (Faker $faker) {
    return [
        //
        'inn_id' => \App\Models\Inn::all()->random()->id,
        'inn_feature_id' => \App\Models\MstFeatureType::all()->random()->id,
    ];
});
