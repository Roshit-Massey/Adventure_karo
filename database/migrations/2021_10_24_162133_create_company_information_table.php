<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('legal_company_name')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('registered_address')->nullable();
            $table->string('registered_address_2')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('company_website')->nullable();
            $table->string('hear_about_us')->nullable();
            $table->text('terms_condition')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('acc_no')->nullable();
            $table->string('acc_holder_name')->nullable();
            $table->string('ifsc')->nullable();
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
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
        Schema::dropIfExists('company_informations');
    }
}
