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
        Schema::table('shop_payments', function (Blueprint $table) {

            $table->bigInteger('creator_id')->nullable();
        });
        Schema::table('shop_orders', function (Blueprint $table) {

            $table->bigInteger('creator_id')->nullable();
        });
        Schema::table('shop_customers', function (Blueprint $table) {

            $table->bigInteger('creator_id')->nullable();
        });
        Schema::table('shop_categories', function (Blueprint $table) {

            $table->bigInteger('creator_id')->nullable();
        });
        Schema::table('shop_products', function (Blueprint $table) {

            $table->bigInteger('creator_id')->nullable();
        });
        Schema::table('shop_services', function (Blueprint $table) {

            $table->bigInteger('creator_id')->nullable();
        });
        Schema::table('shop_tasks', function (Blueprint $table) {

            $table->bigInteger('creator_id')->nullable();

            $table->dropColumn('created_employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_payments', function (Blueprint $table) {

            $table->dropColumn('creator_id');
        });
        Schema::table('shop_orders', function (Blueprint $table) {

            $table->dropColumn('creator_id');
        });
        Schema::table('shop_customers', function (Blueprint $table) {

            $table->dropColumn('creator_id');
        });
        Schema::table('shop_categories', function (Blueprint $table) {

            $table->dropColumn('creator_id');
        });
        Schema::table('shop_products', function (Blueprint $table) {

            $table->dropColumn('creator_id');
        });
        Schema::table('shop_services', function (Blueprint $table) {

            $table->dropColumn('creator_id');
        });
        Schema::table('shop_tasks', function (Blueprint $table) {

            $table->dropColumn('creator_id');

            $table->integer('created_employee_id')->nullable();
        });
    }
};
