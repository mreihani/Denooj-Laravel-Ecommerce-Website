<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_settings', function (Blueprint $table) {
            $table->id();
            $table->string('sms_provider',255)->default('farazsms');
            $table->string('farazsms_username',255)->nullable();
            $table->string('farazsms_password',255)->nullable();
            $table->string('farazsms_number',255)->nullable();
            $table->string('farazsms_signin_pattern',255)->nullable();
            $table->string('farazsms_question_answered_pattern',255)->nullable();
            $table->string('farazsms_order_submitted_pattern',255)->nullable();

            $table->string('ghasedak_api',255)->nullable();
            $table->string('ghasedak_signin_pattern',255)->nullable();
            $table->string('ghasedak_question_answered_pattern',255)->nullable();
            $table->string('ghasedak_order_submitted_pattern',255)->nullable();
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
        Schema::dropIfExists('sms_settings');
    }
}
