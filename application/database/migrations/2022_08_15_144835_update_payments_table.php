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

            $table->dateTime('lost_at')->nullable();
            $table->dateTime('payed_at')->nullable();
            $table->dropColumn('method');
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

            $table->dropColumn('lost_at');
            $table->dropColumn('payed_at');
            $table->string('method');
        });
    }
};
