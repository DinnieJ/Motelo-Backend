<?php

use Illuminate\Database\Seeder;

class OwnerContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Models\OwnerContact::class,30)->create();
    }
}
