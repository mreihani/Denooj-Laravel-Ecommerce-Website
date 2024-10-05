<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('zarinpal')->default(true);
            $table->boolean('idpay')->default(true);
            $table->string('zarinpal_merchant_id', 512)->nullable();
            $table->string('idpay_merchant_id', 512)->nullable();
            $table->string('payment_description', 255)->nullable();
            $table->boolean('sandbox')->default(true);
            $table->string('default_payment_driver',255)->default('zarinpal');
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
        Schema::dropIfExists('payment_settings');
    }
}
