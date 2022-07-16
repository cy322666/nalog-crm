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
        Schema::table('shops', function (Blueprint $table) {
            $table->integer('timezone_id')->nullable();
            $table->integer('currency_id')->nullable();

            $table->dropColumn('timezone');
            $table->dropColumn('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('timezone')->nullable();
            $table->string('currency')->nullable();

            $table->dropColumn('timezone_id');
            $table->dropColumn('currency_id');
        });
    }
};
