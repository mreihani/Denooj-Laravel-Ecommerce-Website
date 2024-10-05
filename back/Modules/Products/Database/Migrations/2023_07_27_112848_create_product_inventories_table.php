<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->decimal('price',19,0);
            $table->decimal('sale_price',19,0)->nullable();
            $table->integer('discount_percent')->nullable();
            $table->boolean('manage_stock')->default(false);
            $table->integer('stock')->default(0);
            $table->enum('stock_status',['in_stock','out_of_stock'])->default('in_stock');
        });
        Schema::table('product_inventories', function(Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('color_id')->references('id')->on('product_colors');
            $table->foreign('size_id')->references('id')->on('product_sizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_inventories');
    }
}
