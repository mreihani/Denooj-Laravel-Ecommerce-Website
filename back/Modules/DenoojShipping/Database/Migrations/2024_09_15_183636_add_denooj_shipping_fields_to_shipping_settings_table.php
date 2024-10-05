<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDenoojShippingFieldsToShippingSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_settings', function (Blueprint $table) {
            $table->boolean('freightage')->default(0);
            $table->boolean('post')->default(0);
            $table->string('freightage_title')->nullable();
            $table->mediumText('freightage_logo')->nullable();
            $table->string('post_title')->nullable();
            $table->mediumText('post_logo')->nullable();
            $table->decimal('post_cost_five',19,0)->nullable();
            $table->decimal('post_cost_ten',19,0)->nullable();
            $table->decimal('post_cost_twenty',19,0)->nullable();
            $table->decimal('post_cost_off_five',19,0)->nullable();
            $table->decimal('post_cost_off_ten',19,0)->nullable();
            $table->decimal('post_cost_off_twenty',19,0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_settings', function (Blueprint $table) {
            $table->dropColumn('freightage');
            $table->dropColumn('post');
            $table->dropColumn('freightage_title');
            $table->dropColumn('freightage_logo');
            $table->dropColumn('post_title');
            $table->dropColumn('post_logo');
            $table->dropColumn('post_cost_five');
            $table->dropColumn('post_cost_ten');
            $table->dropColumn('post_cost_twenty');
            $table->dropColumn('post_cost_off_five');
            $table->dropColumn('post_cost_off_ten');
            $table->dropColumn('post_cost_off_twenty');
        });
    }
}
