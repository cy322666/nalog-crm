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
        Schema::table('shop_events', function (Blueprint $table) {
            $table->dropColumn(['updated_at', 'text', 'link']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_events', function (Blueprint $table) {
            $table->dropColumn(['updated_at', 'text', 'link']);
            $table->integer('updated_at')->nullable();
            $table->integer('text')->nullable();
            $table->integer('link')->nullable();
        });
    }
};
