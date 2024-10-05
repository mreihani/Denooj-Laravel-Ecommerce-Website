<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('author_id');
            $table->string('title',255);
            $table->string('slug',350)->unique();
            $table->text('excerpt');
            $table->longText('body');
            $table->string('image',1024)->nullable();
            $table->text('meta_description')->nullable();
            $table->enum('status', ['published', 'draft', 'pending'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('posts', function(Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('post_categories');
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
        Schema::dropIfExists('posts');
    }
}
