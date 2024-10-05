<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFooterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('footer_icon1',1024)->nullable();
            $table->string('footer_icon2',1024)->nullable();
            $table->string('footer_icon3',1024)->nullable();
            $table->string('footer_icon4',1024)->nullable();
            $table->string('footer_icon1_title',255)->nullable();
            $table->string('footer_icon2_title',255)->nullable();
            $table->string('footer_icon3_title',255)->nullable();
            $table->string('footer_icon4_title',255)->nullable();
            $table->string('footer_logo',1024)->nullable();
            $table->string('footer_about_text',2048)->nullable();
            $table->string('footer_address',255)->nullable();
            $table->string('footer_email',255)->nullable();
            $table->string('footer_phone',255)->nullable();
            $table->mediumText('footer_copyright')->nullable();
            $table->mediumText('footer_designer')->nullable();
            $table->string('footer_box1_title',255)->nullable();
            $table->string('footer_box2_title',255)->nullable();
            $table->string('footer_box3_title',255)->nullable();
            $table->string('footer_box4_title',255)->nullable();
            $table->string('footer_social_title')->nullable();
            $table->mediumText('footer_html')->nullable();
            $table->string('working_hours')->nullable();
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
        Schema::dropIfExists('footer_settings');
    }
}
