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
        Schema::table('shop_order_product', function (Blueprint $table) {

            $table->float('unit_price')->nullable()->change();
            $table->integer('count')->nullable()->change();
            $table->dropColumn('sort');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_order_product', function (Blueprint $table) {

            $table->integer('sort')->nullable();
        });
    }
};
