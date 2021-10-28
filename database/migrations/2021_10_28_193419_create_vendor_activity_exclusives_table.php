<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorActivityExclusivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_activity_exclusives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_activity_id')->nullable();
            $table->unsignedBigInteger('exclusive_id')->nullable();
            $table->foreign('vendor_activity_id')->references('id')->on('vendor_activities')->onDelete('cascade');
            $table->foreign('exclusive_id')->references('id')->on('exclusives')->onDelete('cascade');
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
        Schema::dropIfExists('vendor_activity_exclusives');
    }
}
