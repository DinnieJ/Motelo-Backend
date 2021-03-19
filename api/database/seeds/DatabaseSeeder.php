<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ///for owner
        $this->call(OwnerTableSeeder::class);
        $this->call(MstContactTypeSeeder::class);
        $this->call(OwnerContactTableSeeder::class);

        //for inn
        $this->call(InnTableSeeder::class);
        $this->call(MstFeatureTypeTableSeeder::class);
        $this->call(InnFeatureTableSeeder::class);

        //for tenant
        $this->call(TenantTableSeeder::class);


        //for room
        $this->call(MstRoomTypeTableSeeder::class);
        $this->call(MstGenderTypeSeeder::class);
        $this->call(RoomTableSeeder::class);
        $this->call(RoomCommentTableSeeder::class);

        $this->call(CollaboratorSeeder::class);
        $this->call(MstUtilityTypeSeeder::class);
    }
}
