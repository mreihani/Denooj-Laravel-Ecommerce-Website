<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSidebarToPagesAndPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('sidebar')->default(true)->after('faq');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('sidebar')->default(true)->after('faq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages_and_posts', function (Blueprint $table) {
            //
        });
    }
}
