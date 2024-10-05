<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author_id');
            $table->string('title');
            $table->mediumText('thumbnail');
            $table->enum('type',['image','video'])->default('image');
            $table->enum('status',['published', 'draft'])->default('draft');
            $table->mediumText('image_url')->nullable();
            $table->mediumText('video_url')->nullable();
            $table->boolean('show_button')->default(false);
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table('stories', function(Blueprint $table) {
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
        Schema::dropIfExists('stories');
    }
}
