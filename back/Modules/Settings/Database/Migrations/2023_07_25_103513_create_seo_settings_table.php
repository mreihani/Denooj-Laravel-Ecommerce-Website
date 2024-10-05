<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();

            // permalink base
            $table->string('product_base')->default('product');
            $table->string('category_base')->default('category');
            $table->string('tag_base')->default('tag');
            $table->string('post_category_base')->default('post-category');
            $table->string('post_tag_base')->default('post-tag');
            $table->string('post_base')->default('post');
            $table->string('page_base')->default('page');

            // sitemap includes
            $table->boolean('post_sitemap_inc')->default(true);
            $table->boolean('post_cat_sitemap_inc')->default(true);
            $table->boolean('post_tag_sitemap_inc')->default(true);
            $table->boolean('product_sitemap_inc')->default(true);
            $table->boolean('product_cat_sitemap_inc')->default(true);
            $table->boolean('product_tag_sitemap_inc')->default(true);
            $table->boolean('page_sitemap_inc')->default(true);

            // index noindex
            $table->enum('site_index',['index','noindex'])->default('index');
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
        Schema::dropIfExists('seo_settings');
    }
}
