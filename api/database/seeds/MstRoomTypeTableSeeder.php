<?php

use Illuminate\Database\Seeder;

class MstRoomTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_room_type')->delete();
        $data = [
            [
                'title' => 'Phòng cho thuê',
                'description' => 'Phòng cho thuê',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            [
                'title' => 'Nhà nguyên căn',
                'description' => 'Nhà nguyên căn',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            [
                'title' => 'Chung cư',
                'description' => 'Chung cư',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];
        \App\Models\MstRoomType::insert($data);

    }
}

