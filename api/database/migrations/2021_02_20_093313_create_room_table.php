<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_room', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('inn_id');
            $table->foreign('inn_id')->references('id')->on('tb_inn')->cascadeOnDelete();
            $table->unsignedBigInteger('room_type_id');
            $table->foreign('room_type_id')->references('id')->on('mst_room_type')->cascadeOnDelete();
            $table->float('price');
            $table->float('acreage');
            $table->text('description');
            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at');
            $table->tinyInteger('available')->default(1);
            $table->integer('status');
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
        Schema::dropIfExists('tb_room');
    }
}
