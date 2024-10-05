<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddButtonsToGeneralSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->boolean('display_whatsapp_btn')->after('pinterest')->default(true);
            $table->boolean('display_call_btn')->after('pinterest')->default(true);
            $table->string('whatsapp_btn_title')->after('pinterest')->nullable();
            $table->string('whatsapp_btn_number')->after('pinterest')->nullable();
            $table->string('call_btn_title')->after('pinterest')->nullable();
            $table->string('call_btn_number')->after('pinterest')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            //
        });
    }
}
