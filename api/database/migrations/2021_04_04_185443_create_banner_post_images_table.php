<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerPostImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_banner_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('banner_id');
            $table->string('image_url');
            $table->string('filename');
            $table->timestamps();

            $table->foreign('banner_id')->references('id')->on('tb_banner_post')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_banner_image');
    }
}
