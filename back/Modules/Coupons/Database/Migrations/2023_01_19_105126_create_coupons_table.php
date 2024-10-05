<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->enum('type',['percent','amount'])->default('percent');
            $table->integer('percent')->nullable()->default(0);
            $table->decimal('amount',9,0)->nullable()->default(0);
            $table->integer('max_usage')->default(0);
            $table->bigInteger('min_price')->default(0);
            $table->timestamp('expire_at');
            $table->timestamps();
        });

        Schema::create('user_coupon', function (Blueprint $table) {
            $table->id();
            $table->integer('coupon_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
