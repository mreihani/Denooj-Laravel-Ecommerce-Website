<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeShippingFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::Table('orders', function (Blueprint $table) {
            $table->string('shipping_address')->nullable()->nullable()->change();
            $table->string('shipping_province')->nullable()->nullable()->change();
            $table->string('shipping_city')->nullable()->nullable()->change();
            $table->string('shipping_post_code')->nullable()->nullable()->change();
            $table->string('shipping_phone')->nullable()->nullable()->change();
            $table->string('shipping_full_name')->nullable()->nullable()->change();
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
