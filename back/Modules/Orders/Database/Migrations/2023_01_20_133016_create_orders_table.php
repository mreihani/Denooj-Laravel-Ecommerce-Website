<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('order_number');
            $table->string('shipping_address');
            $table->string('shipping_province');
            $table->string('shipping_city');
            $table->string('shipping_post_code');
            $table->string('shipping_phone');
            $table->string('shipping_full_name');
            $table->enum('status', ['pending_payment','ongoing','completed','cancel'])->default('pending_payment');
            $table->decimal('price',19,0);
            $table->decimal('paid_price',19,0);
            $table->boolean('is_paid')->default(false);
            $table->string('payment_method');
            $table->string('notes')->nullable();
            $table->decimal('shipping_cost',9,0);
            $table->enum('shipping_method',['post_pishtaz','tipax']);
            $table->string('coupons')->nullable();
            $table->decimal('paid_from_wallet',19,0)->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->bigInteger('price');
        });

        Schema::table('order_items', function(Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
