<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlogFieldsToAppearanceSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appearance_settings', function (Blueprint $table) {
            $table->string('home_blog_title')->nullable()->after('featured_products_btn_link');
            $table->string('home_blog_btn_text')->nullable()->after('featured_products_btn_link');
            $table->string('home_blog_bg_color')->nullable()->after('featured_products_btn_link');
            $table->string('home_blog_title_color')->nullable()->after('featured_products_btn_link');
            $table->string('home_blog_btn_color')->nullable()->after('featured_products_btn_link');
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
