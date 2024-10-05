<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminLoginLogoToAppearanceSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appearance_settings', function (Blueprint $table) {
            $table->string('admin_signin_logo')->nullable()->after('admin_logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appearance_settings', function (Blueprint $table) {
            //
        });
    }
}
