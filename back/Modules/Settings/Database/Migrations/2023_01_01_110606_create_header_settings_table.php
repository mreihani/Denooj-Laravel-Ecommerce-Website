<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_logo',1024)->nullable();
            $table->string('header_search_placeholder',255)->nullable();
            $table->boolean('display_header_support')->default(true);
            $table->string('header_support_text',255)->nullable();
            $table->string('header_support_link',255)->nullable();
            $table->string('header_support_link_text',255)->nullable();
            $table->string('header_support_icon',255)->nullable();
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
        Schema::dropIfExists('header_settings');
    }
}
