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
            $table->dropColumn('featured');
            $table->dropColumn('is_visible');
            $table->dropColumn('backorder');
            $table->dropColumn('published_at');
            $table->dropColumn('seo_title');
            $table->dropColumn('seo_description');

            $table->bigInteger('shop_id')->nullable();
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
            $table->string('featured')->nullable();
            $table->string('is_visible')->nullable();
            $table->string('backorder')->nullable();
            $table->string('published_at')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_title')->nullable();

            $table->dropColumn('shop_id');
        });
    }
};
