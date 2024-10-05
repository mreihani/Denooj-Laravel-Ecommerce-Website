<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('post_pishtaz')->default(true);
            $table->boolean('tipax')->default(true);
            $table->decimal('cost_post_pishtaz',19,0)->default(20000);
            $table->decimal('free_shipping_limit',19,0)->nullable();
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
        Schema::dropIfExists('shipping_settings');
    }
}
