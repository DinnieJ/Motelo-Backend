<?php

use Illuminate\Database\Seeder;

class RoomCommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Models\RoomComment::class, 30)->create();
    }
}
