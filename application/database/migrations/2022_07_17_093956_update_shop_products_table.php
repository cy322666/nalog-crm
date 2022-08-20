<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_products', function (Blueprint $table) {
            $table->dropColumn('slug');
//            $table->dropColumn('is_visible');
//            $table->dropColumn('backorder');
            $table->dropColumn('shop_brand_id');
//            $table->dropColumn('featured');
//            $table->dropColumn('published_at');
//            $table->dropColumn('seo_description');
            $table->dropColumn('type');

            $table->integer('product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_products', function (Blueprint $table) {
            $table->string('slug')->nullable();
            $table->string('is_visible')->nullable();
            $table->string('backorder')->nullable();
            $table->string('shop_brand_id')->nullable();
            $table->string('featured')->nullable();
            $table->string('published_at')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('type')->nullable();

            $table->dropColumn('product_id');
        });
    }
};
