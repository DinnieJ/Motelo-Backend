<?php

use Illuminate\Database\Seeder;

class MstFeatureTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_feature_type')->delete();
        $data = [
            [
                'title' => 'Wifi',
                'description' => 'Wifi',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'WC Riêng',
                'description' => 'WC Riêng',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Bình nóng lạnh',
                'description' => 'Bình nóng lạnh',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Điều hòa',
                'description' => 'Điều hòa',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Nhà bếp',
                'description' => 'Nhà bếp',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Tủ lạnh',
                'description' => 'Tủ lạnh',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Chỗ để xe',
                'description' => 'Chỗ để xe',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Giờ giới nghiêm',
                'description' => 'Giờ giới nghiêm',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Chủ riêng',
                'description' => 'Chủ riêng',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Máy giặt',
                'description' => 'Máy giặt',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Thú nuôi',
                'description' => 'Thú nuôi',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Gác lửng',
                'description' => 'Gác lửng',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Tủ đồ',
                'description' => 'Tủ đồ',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Camera',
                'description' => 'Camera',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Khóa vân tay',
                'description' => 'Khóa vân tay',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Bảo vệ',
                'description' => 'Bảo vệ',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]


        ];
        \App\Models\MstFeatureType::insert($data);
    }
}
