<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('experience_id');
            $table->string('image');
            $table->string('original_image_name');
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experience_images');
    }
}
