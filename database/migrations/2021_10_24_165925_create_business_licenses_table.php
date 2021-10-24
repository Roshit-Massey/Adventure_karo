<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('certificate_of_incorporation')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('pan_image')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('gst_image')->nullable();
            $table->text('other_document_images')->nullable();
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('business_licenses');
    }
}
