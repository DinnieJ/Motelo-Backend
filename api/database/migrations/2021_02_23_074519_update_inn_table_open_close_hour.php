<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInnTableOpenCloseHour extends Migration
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
            $table->integer('open_hour')->nullable()->after('electric_price');
            $table->integer('open_minute')->nullable()->after('open_hour');
            $table->integer('close_hour')->nullable()->after('open_minute');
            $table->integer('close_minute')->nullable()->after('close_hour');
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
            $table->dropColumn(['open_hour', 'open_minute', 'close_hour', 'close_minute']);
        });
    }
}
