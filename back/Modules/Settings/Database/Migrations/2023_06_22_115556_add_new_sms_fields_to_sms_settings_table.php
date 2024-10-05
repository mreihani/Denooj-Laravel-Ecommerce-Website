<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewSmsFieldsToSmsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_settings', function (Blueprint $table) {
            $table->string('kavenegar_product_comment_pattern',255)->nullable();
            $table->string('ghasedak_product_comment_pattern',255)->nullable();
            $table->string('farazsms_product_comment_pattern',255)->nullable();
            $table->string('kavenegar_post_comment_pattern',255)->nullable();
            $table->string('ghasedak_post_comment_pattern',255)->nullable();
            $table->string('farazsms_post_comment_pattern',255)->nullable();
            $table->string('kavenegar_question_pattern',255)->nullable();
            $table->string('ghasedak_question_pattern',255)->nullable();
            $table->string('farazsms_question_pattern',255)->nullable();
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
