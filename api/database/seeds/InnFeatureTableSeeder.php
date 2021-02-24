<?php

use Illuminate\Database\Seeder;

class InnFeatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Models\InnFeature::class, 30)->create();
    }
}
