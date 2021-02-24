<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInnFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_inn_feature', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inn_id');
            $table->foreign('inn_id')->references('id')->on('tb_inn')->cascadeOnDelete();
            $table->unsignedBigInteger('inn_feature_id');
            $table->foreign('inn_feature_id')->references('id')->on('mst_feature_type')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inn_feature');
    }
}
