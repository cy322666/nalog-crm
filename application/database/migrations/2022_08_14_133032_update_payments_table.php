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

            $table->dropColumn('currency_id');
            $table->dropColumn('left_payed');
            $table->dropColumn('amount_payed');
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

            $table->integer('currency_id')->nullable();
            $table->integer('left_payed')->nullable();
            $table->integer('amount_payed')->nullable();
        });
    }
};
