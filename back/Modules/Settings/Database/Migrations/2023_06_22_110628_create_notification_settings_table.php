<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('product_comment_email')->default(true);
            $table->boolean('post_comment_email')->default(true);
            $table->boolean('question_email')->default(true);
            $table->boolean('new_order_email')->default(true);
            $table->boolean('product_comment_sms')->default(false);
            $table->boolean('post_comment_sms')->default(false);
            $table->boolean('question_sms')->default(true);
            $table->boolean('new_order_sms')->default(true);
            $table->boolean('user_order_completed_sms')->default(true);
            $table->boolean('user_order_submitted_sms')->default(true);
            $table->boolean('user_question_answered_sms')->default(true);
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
        Schema::dropIfExists('notification_settings');
    }
}
