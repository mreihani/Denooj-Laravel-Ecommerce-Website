<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKilogramPriceToShippingSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_settings', function (Blueprint $table) {
            $table->decimal('cost_post_pishtaz_kilogram',19,0)->after('cost_post_pishtaz');
            $table->decimal('cost_bike_kilogram',19,0)->after('cost_bike');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
