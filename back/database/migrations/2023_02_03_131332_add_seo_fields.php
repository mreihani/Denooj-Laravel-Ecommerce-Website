<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeoFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('h1_hidden',255)->nullable();
            $table->string('nav_title',255)->nullable();
            $table->string('canonical',512)->nullable();
            $table->string('meta_description',512)->nullable();
            $table->string('title_tag',255)->nullable();
            $table->string('image_alt',255)->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('h1_hidden',255)->nullable();
            $table->string('nav_title',255)->nullable();
            $table->string('canonical',512)->nullable();
            $table->string('meta_description',512)->nullable();
            $table->string('title_tag',255)->nullable();
            $table->string('seo_description',512)->nullable();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('h1_hidden',255)->nullable();
            $table->string('nav_title',255)->nullable();
            $table->string('canonical',512)->nullable();
            $table->string('meta_description',512)->nullable();
            $table->string('title_tag',255)->nullable();
            $table->string('image_alt',255)->nullable();
        });
        Schema::table('post_categories', function (Blueprint $table) {
            $table->string('h1_hidden',255)->nullable();
            $table->string('nav_title',255)->nullable();
            $table->string('canonical',512)->nullable();
            $table->string('meta_description',512)->nullable();
            $table->string('title_tag',255)->nullable();
            $table->string('seo_description',512)->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('h1_hidden',255)->nullable();
            $table->string('nav_title',255)->nullable();
            $table->string('canonical',512)->nullable();
            $table->string('meta_description',512)->nullable();
            $table->string('title_tag',255)->nullable();
            $table->string('image_alt',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
