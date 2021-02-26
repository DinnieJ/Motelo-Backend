<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tb_room', function (Blueprint $table) {
            $table->unsignedBigInteger('gender_type_id')->after('status');
            $table->foreign('gender_type_id')->references('id')->on('mst_gender_type')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('tb_room', function (Blueprint $table) {
            $table->dropColumn(['gender_type_id']);
        });
    }
}
