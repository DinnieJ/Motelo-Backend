<?php

use Illuminate\Database\Seeder;

class MstGenderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_gender_type')->delete();
        $data = [
            [
                'title' => 'both',
                'description' => 'Nam & Nữ',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'man',
                'description' => 'Nam',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'woman',
                'description' => 'Nữ',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]

        ];
        \App\Models\MstGenderType::insert($data);
    }

}
