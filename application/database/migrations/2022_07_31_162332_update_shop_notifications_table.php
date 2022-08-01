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
        Schema::table('shop_notifications', function (Blueprint $table) {
            $table->dateTime('pushed_at')->nullable();
            $table->boolean('is_pushed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_notifications', function (Blueprint $table) {
            $table->dropColumn('pushed_at');
            $table->dropColumn('is_pushed');
        });
    }
};
