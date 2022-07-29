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
            $table->dropColumn(['number', 'currency_id']);
            $table->renameColumn('notes', 'description');
            $table->renameColumn('total_price', 'price');
            $table->string('name', 30)->nullable();
            $table->bigInteger('order_id')->nullable();
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
            $table->string('number')->nullable();
            $table->string('currency_id')->nullable();
            $table->renameColumn('description', 'notes');
            $table->renameColumn('price', 'total_price');
            $table->dropColumn('name');
            $table->dropColumn('order_id');
        });
    }
};
