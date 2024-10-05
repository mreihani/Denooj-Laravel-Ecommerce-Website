<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderNotificationFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function(Blueprint $table) {
            $table->string('completed_at')->nullable()->after('updated_at');
        });
        Schema::table('sms_settings', function (Blueprint $table) {
            $table->string('kavenegar_order_completed_pattern',255)->nullable();
            $table->string('ghasedak_order_completed_pattern',255)->nullable();
            $table->string('farazsms_order_completed_pattern',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
