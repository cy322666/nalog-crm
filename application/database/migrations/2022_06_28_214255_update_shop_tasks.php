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
        Schema::table('shop_tasks', function (Blueprint $table) {
            $table->dateTime('last_failed_at')->nullable();
            $table->boolean('failed')->default(false);
            $table->integer('count_failed')->default(0);
            $table->integer('count_rescheduled')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('shop_tasks', [
            'last_failed_at',
            'failed',
            'count_failed',
            'count_rescheduled',
        ]);
    }
};
