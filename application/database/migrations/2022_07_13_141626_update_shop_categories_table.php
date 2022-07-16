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
        Schema::table('shop_categories', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('is_visible');
            $table->dropColumn('seo_title');
            $table->dropColumn('seo_description');
            $table->dropColumn('position');

            $table->integer('category_id')->nullable();
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
        Schema::table('shop_categories', function (Blueprint $table) {
            $table->string('parent_id')->nullable();
            $table->string('is_visible')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('position')->nullable();

            $table->dropColumn('category_id');
            $table->dropColumn('shop_id');
        });
    }
};
