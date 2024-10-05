<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo',1024)->nullable();
            $table->string('signature',1024)->nullable();
            $table->string('address',1024)->nullable();
            $table->string('phone',255)->nullable();
            $table->string('postcode',255)->nullable();
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
        Schema::dropIfExists('factor_settings');
    }
}
