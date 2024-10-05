<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeShippingColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_settings', function (Blueprint $table) {
            $table->mediumText('post_pishtaz_logo')->nullable()->change();
            $table->mediumText('bike_logo')->nullable()->change();
            $table->mediumText('tipax_logo')->nullable()->change();
            $table->string('post_pishtaz_title')->nullable()->change();
            $table->string('bike_title')->nullable()->change();
            $table->string('tipax_title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
}
