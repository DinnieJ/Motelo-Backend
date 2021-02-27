<?php

use Illuminate\Database\Seeder;

class RoomGenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Models\RoomGender::class, 30)->create();
    }
}
