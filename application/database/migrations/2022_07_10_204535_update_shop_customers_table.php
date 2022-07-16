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
            $table->string('shop_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('type')->nullable();

            $table->index(['shop_id', 'id']);
            $table->index('customer_id');
            $table->index('type');
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
            $table->dropColumn('shop_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('type');
        });
    }
};
