<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author_id');
            $table->string('code',15)->unique();
            $table->string('sku')->nullable();
            $table->string('title',255);
            $table->string('title_latin')->nullable();
            $table->string('slug',355)->unique();
            $table->string('short_description',1024)->nullable();
            $table->string('image',512)->nullable();
            $table->mediumText('images')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('manage_stock')->default(false);
            $table->integer('stock')->default(0);
            $table->enum('stock_status',['in_stock','out_of_stock'])->default('in_stock');
            $table->decimal('price',19,0);
            $table->decimal('sale_price',19,0)->nullable();
            $table->integer('discount_percent')->nullable();
            $table->enum('status', ['draft','published'])->default('draft');
            $table->boolean('recommended')->default(false);
            $table->integer('sell_count')->default(0);
            $table->json('attributes')->nullable();
            $table->json('total_attributes')->nullable();
            $table->unsignedBigInteger('copy_from')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('products', function(Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('admins');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
