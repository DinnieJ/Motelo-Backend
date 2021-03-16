<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilityImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_utility_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utility_id');
            $table->string('image_url');
            $table->string('filename');
            $table->timestamps();

            $table->foreign('utility_id')->references('id')->on('tb_utility')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_utility_image');
    }
}
