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
        Schema::table('shop_customers', function (Blueprint $table) {
            $table->dropColumn(['photo', 'gender']);
            $table->bigInteger('inn')->nullable();
            $table->bigInteger('kpp')->nullable();
            $table->bigInteger('rs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_customers', function (Blueprint $table) {
            $table->dropColumn(['inn', 'kpp', 'rs']);
            $table->string('photo')->nullable();
            $table->string('gender')->nullable();
        });
    }
};
