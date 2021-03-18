<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomConfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_room_confirmation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('confirmed_by');
            $table->tinyInteger('status');
            $table->text('reject_description')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('tb_owner')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('tb_room')->onDelete('cascade');
            $table->foreign('confirmed_by')->references('id')->on('tb_collaborator')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_room_confirmation');
    }
}
