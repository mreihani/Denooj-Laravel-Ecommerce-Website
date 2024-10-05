<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDenoojSmsToSmsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_settings', function (Blueprint $table) {
            $table->string('denooj_post',255)->nullable();
            $table->string('denooj_ordinary_freightage',255)->nullable();
            $table->string('denooj_coupon_freightage',255)->nullable();
            $table->string('denooj_three_days',255)->nullable();
            $table->string('denooj_fifteen_days',255)->nullable();
            $table->string('denooj_fifteen_days_link',255)->nullable();
            $table->string('denooj_fourty_days',255)->nullable();
            $table->string('denooj_fourty_days_link',255)->nullable();
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
            $table->dropColumn('denooj_post');
            $table->dropColumn('denooj_ordinary_freightage');
            $table->dropColumn('denooj_coupon_freightage');
            $table->dropColumn('denooj_three_days');
            $table->dropColumn('denooj_fifteen_days');
            $table->dropColumn('denooj_fifteen_days_link');
            $table->dropColumn('denooj_fourty_days');
            $table->dropColumn('denooj_fourty_days_link');
        });
    }
}
