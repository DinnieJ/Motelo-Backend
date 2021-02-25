<?php

use Illuminate\Database\Seeder;

class MstContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_contact_type')->delete();
        $data = [
            [
                'title' => 'Email',
                'icon' => null,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Phone',
                'icon' => null,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Zalo',
                'icon' => null,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Facebook',
                'icon' => null,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]

        ];
        \App\Models\MstContactType::insert($data);
    }
}
