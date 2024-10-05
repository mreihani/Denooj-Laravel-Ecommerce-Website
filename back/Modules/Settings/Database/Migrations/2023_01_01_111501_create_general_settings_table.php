<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title', 255)->nullable();
            $table->string('instagram', 1024)->nullable();
            $table->string('twitter', 1024)->nullable();
            $table->string('linkedin', 1024)->nullable();
            $table->string('facebook', 1024)->nullable();
            $table->string('youtube', 1024)->nullable();
            $table->string('whatsapp', 1024)->nullable();
            $table->string('telegram', 1024)->nullable();
            $table->string('pinterest', 1024)->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
