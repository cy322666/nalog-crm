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
        Schema::table('shop_orders', function (Blueprint $table) {

            $table->integer('pay_parts')->default(1);
        });

        Schema::table('shop_payments', function (Blueprint $table) {

            $table->dropColumn('steps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_orders', function (Blueprint $table) {

            $table->dropColumn('pay_parts');
        });

        Schema::table('shop_payments', function (Blueprint $table) {

            $table->integer('steps')->nullable();
        });
    }
};
