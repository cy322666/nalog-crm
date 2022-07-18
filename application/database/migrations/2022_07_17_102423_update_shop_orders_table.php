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
            $table->dropColumn('currency');
            $table->dropColumn('status');
            $table->dropColumn('title');

            $table->integer('currency_id')->nullable();
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
            $table->string('currency')->nullable();
            $table->string('status')->nullable();
            $table->string('title')->nullable();

            $table->dropColumn('currency_id');
        });
    }
};
