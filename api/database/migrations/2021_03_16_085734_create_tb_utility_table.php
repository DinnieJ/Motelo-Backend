<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbUtilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_utility', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utility_type_id');
            $table->string('title');
            $table->text('description');
            $table->string('address')->nullable();
            $table->point('location');
            $table->unsignedBigInteger('created_by_collaborator_id');
            $table->timestamps();

            $table->foreign('utility_type_id')->references('id')->on('mst_utility_type')->cascadeOnDelete();
            $table->foreign('created_by_collaborator_id')->references('id')->on('tb_collaborator')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_utility');
    }
}
