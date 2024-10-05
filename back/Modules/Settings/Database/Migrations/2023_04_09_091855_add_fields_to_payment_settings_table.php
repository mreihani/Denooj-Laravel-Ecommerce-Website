<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->string('parsian_pin_code')->after('idpay_merchant_id')->nullable();
            $table->string('parsian_pin_code_sandbox')->after('idpay_merchant_id')->nullable();
            $table->string('parsian_terminal')->after('idpay_merchant_id')->nullable();
            $table->string('mellat_payane')->after('idpay_merchant_id')->nullable();
            $table->string('mellat_username')->after('idpay_merchant_id')->nullable();
            $table->string('mellat_password')->after('idpay_merchant_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            //
        });
    }
}
