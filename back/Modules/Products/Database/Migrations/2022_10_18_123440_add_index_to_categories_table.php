<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('section_subtitle')->nullable();
            $table->integer('index')->default(0);
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->string('section_subtitle')->nullable();
            $table->integer('index')->default(0);
        });
        Schema::table('sub_sub_categories', function (Blueprint $table) {
            $table->string('section_subtitle')->nullable();
            $table->integer('index')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
}
