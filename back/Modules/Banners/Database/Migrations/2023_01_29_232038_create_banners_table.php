<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link',1024)->nullable();
            $table->string('image',1024);
            $table->enum('lg_col',['1','2','3','4','5','6','7','8','9','10','11','12'])->default('12');
            $table->enum('sm_col',['1','2','3','4','5','6','7','8','9','10','11','12'])->default('12');
            $table->enum('col',['1','2','3','4','5','6','7','8','9','10','11','12'])->default('12');
            $table->string('location')->default('main_slider');
            $table->integer('sort')->default(1);
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
        Schema::dropIfExists('banners');
    }
}
