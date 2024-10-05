<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChengeSmsSettingsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_settings', function (Blueprint $table) {
            $table->string('farazsms_username',255)->nullable()->change();
            $table->string('farazsms_password',255)->nullable()->change();
            $table->string('farazsms_number',255)->nullable()->change();
            $table->string('farazsms_signin_pattern',255)->nullable()->change();
            $table->string('farazsms_order_submitted_pattern',255)->nullable()->change();
            $table->string('farazsms_question_answered_pattern',255)->nullable()->change();
            $table->string('farazsms_order_submitted_pattern',255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
