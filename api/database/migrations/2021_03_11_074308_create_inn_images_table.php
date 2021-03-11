<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInnImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_inn_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inn_id');
            $table->foreign('inn_id')->references('id')->on('tb_inn')->cascadeOnDelete();
            $table->string('image_url');
            $table->string('filename');
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
        Schema::dropIfExists('tb_inn_image');
    }
}
