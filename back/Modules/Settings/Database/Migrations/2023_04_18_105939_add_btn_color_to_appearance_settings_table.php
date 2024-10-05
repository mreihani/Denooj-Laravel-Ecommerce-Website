<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBtnColorToAppearanceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appearance_settings', function (Blueprint $table) {
            $table->string('featured_products_btn_color')->nullable()->after('featured_products_arrows_icon_color');
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
