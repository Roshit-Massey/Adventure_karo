<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_social')->default(0)->nullable()->after('remember_token')->comment('1-Normal,2-Social');
            $table->string('otp')->nullable()->after('is_social');
            $table->boolean('is_verify')->nullable()->after('otp')->default(0);
            $table->string('profile_image')->nullable()->after('password');
            $table->string('original_image_name')->nullable()->after('profile_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_social');
            $table->dropColumn('otp');
            $table->dropColumn('is_verify');
            $table->dropColumn('profile_image');
            $table->dropColumn('original_image_name');
        });
    }
}
