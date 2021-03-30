<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePriceInnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tb_inn', function (Blueprint $table) {
            $table->unsignedBigInteger('wifi_price')->after('electric_price');
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
        Schema::table('tb_inn', function (Blueprint $table) {
            $table->dropColumn(['wifi_price']);
        });
    }
}
