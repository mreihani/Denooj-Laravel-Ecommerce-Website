<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexMetaFieldToMultipleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('meta_index',['index','noindex'])->default('index');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->enum('meta_index',['index','noindex'])->default('index');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->enum('meta_index',['index','noindex'])->default('index');
        });

        Schema::table('post_categories', function (Blueprint $table) {
            $table->enum('meta_index',['index','noindex'])->default('index');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->enum('meta_index',['index','noindex'])->default('index');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->enum('meta_index',['index','noindex'])->default('index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multiple', function (Blueprint $table) {
            //
        });
    }
}
