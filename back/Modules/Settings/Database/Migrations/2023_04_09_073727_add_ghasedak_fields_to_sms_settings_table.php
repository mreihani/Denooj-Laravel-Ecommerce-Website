<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGhasedakFieldsToSmsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_settings', function (Blueprint $table) {
            $table->string('ghasedak_api',255)->nullable();
            $table->string('ghasedak_signin_pattern',255)->nullable();
            $table->string('ghasedak_question_answered_pattern',255)->nullable();
            $table->string('ghasedak_order_submitted_pattern',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_settings', function (Blueprint $table) {
            //
        });
    }
}
