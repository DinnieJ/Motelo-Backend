<?php

use Illuminate\Database\Seeder;

class InnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       factory(\App\Models\Inn::class,30)->create();

    }
}
