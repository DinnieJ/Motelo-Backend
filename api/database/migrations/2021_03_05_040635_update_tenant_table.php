<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTenantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tb_tenant', function (Blueprint $table) {
//            $table->unsignedBigInteger('gender_type_id')->after('status');
//            $table->foreign('gender_type_id')->references('id')->on('mst_gender_type')->cascadeOnDelete();
            $table->string('phone_number')->after('email');
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
        Schema::table('tb_tenant', function (Blueprint $table) {
            $table->dropColumn(['phone_number']);
        });
    }
}
