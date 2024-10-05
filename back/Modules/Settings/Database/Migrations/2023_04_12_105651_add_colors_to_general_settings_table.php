<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorsToGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->string('main_color')->after('call_btn_number')->nullable();
            $table->string('main_color_rgb')->after('call_btn_number')->nullable();
            $table->string('secondary_color')->after('call_btn_number')->nullable();
            $table->string('secondary_color_rgb')->after('call_btn_number')->nullable();
            $table->string('link_color')->after('call_btn_number')->nullable();
            $table->string('link_color_rgb')->after('call_btn_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            //
        });
    }
}
