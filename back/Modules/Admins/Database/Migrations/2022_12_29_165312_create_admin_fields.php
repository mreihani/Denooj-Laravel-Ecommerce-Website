<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobile')->nullable();
            $table->longText('avatar')->nullable();
            $table->mediumText('bio')->nullable();
            $table->string('instagram',512)->nullable();
            $table->string('youtube',512)->nullable();
            $table->string('linkedin',512)->nullable();
            $table->string('twitter',512)->nullable();
            $table->string('telegram',512)->nullable();
            $table->string('facebook',512)->nullable();
            $table->string('dribbble',512)->nullable();
            $table->string('pinterest',512)->nullable();
            $table->string('soundcloud',512)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('admin_fields');
    }
}
