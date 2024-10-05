<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppearanceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appearance_settings', function (Blueprint $table) {
            $table->id();
            $table->string('main_color')->nullable();
            $table->string('main_color_rgb')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('secondary_color_rgb')->nullable();
            $table->string('link_color')->nullable();
            $table->string('link_color_rgb')->nullable();
            $table->string('call_button_color')->nullable();
            $table->string('whatsapp_button_color')->nullable();

            $table->string('featured_products_title')->nullable();
            $table->string('featured_products_count')->nullable();
            $table->string('featured_products_items')->nullable();
            $table->string('featured_products_items_tablet')->nullable();
            $table->string('featured_products_items_mobile')->nullable();
            $table->string('featured_products_bg_color')->nullable();
            $table->string('featured_products_title_color')->nullable();
            $table->string('featured_products_title_icon_color')->nullable();
            $table->string('featured_products_title_icon_bg_color')->nullable();
            $table->string('featured_products_arrows_color')->nullable();
            $table->string('featured_products_arrows_icon_color')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appearance_settings');
    }
}
