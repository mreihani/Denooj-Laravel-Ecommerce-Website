<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFaqFieldToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->longText('home_faq')->nullable();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->longText('faq')->nullable();
        });
        Schema::table('post_categories', function (Blueprint $table) {
            $table->longText('faq')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->longText('faq')->nullable();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->longText('faq')->nullable();
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->longText('faq')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
}
