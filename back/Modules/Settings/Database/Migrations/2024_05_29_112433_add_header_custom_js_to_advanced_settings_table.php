<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeaderCustomJsToAdvancedSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advanced_settings', function (Blueprint $table) {
            $table->longText('custom_header_js')->nullable()->after('custom_js');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advanced_settings', function (Blueprint $table) {

        });
    }
}
