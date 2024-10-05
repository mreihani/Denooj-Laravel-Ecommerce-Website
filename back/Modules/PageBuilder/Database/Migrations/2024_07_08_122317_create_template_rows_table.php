<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('template_id');
            $table->string('widget_type');
            $table->string('widget_name');
            $table->string('widget_icon')->nullable();
            $table->integer('order')->default(1);
            $table->integer('margin_top')->default(20);
            $table->integer('margin_bottom')->default(20);
            $table->longText('custom_css')->nullable();
            $table->string('css_id')->nullable();
            $table->enum('layout',['full','box'])->default('box');

            $table->string('stories_stroke_color')->nullable();
            $table->enum('stories_shape',['circle','square'])->default('circle');
            $table->boolean('stories_show_title')->default(true);

            $table->boolean('featured_categories_show_count')->default(true);
            $table->string('featured_categories_overlay_color')->nullable();
            $table->integer('featured_categories_grid_item_per_row')->default(3);
            $table->integer('featured_categories_grid_item_per_row_tablet')->default(4);
            $table->integer('featured_categories_grid_item_per_row_mobile')->default(6);
            $table->integer('featured_categories_grid_items_count')->default(8);

            $table->string('featured_products_title')->nullable();
            $table->string('featured_products_subtitle',1024)->nullable();
            $table->string('featured_products_title_icon')->nullable();
            $table->string('featured_products_count')->nullable();
            $table->string('featured_products_bg_color')->nullable();
            $table->string('featured_products_title_color')->nullable();
            $table->string('featured_products_title_icon_color')->nullable();
            $table->string('featured_products_title_icon_bg_color')->nullable();
            $table->string('featured_products_arrows_color')->nullable();
            $table->string('featured_products_arrows_icon_color')->nullable();
            $table->string('featured_products_btn_color')->nullable();
            $table->string('featured_products_btn_color_hover')->nullable();
            $table->string('featured_products_btn_link',1024)->nullable();
            $table->string('featured_products_categories_source')->nullable();
            $table->string('featured_products_source')->default('newest');

            $table->boolean('featured_products_available')->default(true);
            $table->boolean('featured_products_recommended')->default(false);
            $table->boolean('featured_products_discounted')->default(false);

            $table->longText('editor_content')->nullable();
            $table->longText('faq')->nullable();

            $table->timestamps();
        });

        Schema::table('template_rows', function (Blueprint $table) {
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_rows');
    }
}
