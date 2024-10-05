<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShippingWaysFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_settings', function (Blueprint $table) {
            $table->string('tipax_title');
            $table->mediumText('tipax_logo');
            $table->string('post_pishtaz_title');
            $table->mediumText('post_pishtaz_logo');
            $table->string('bike_title');
            $table->mediumText('bike_logo');
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
