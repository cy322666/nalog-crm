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
            $table->dropColumn('reference');
            $table->dropColumn('provider');
            $table->dropColumn('currency');
            $table->integer('provider_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->integer('method_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->float('amount_payed')->default(0);
            $table->float('left_payed')->nullable();

            $table->string('name', 50)->nullable();
            $table->boolean('payed')->default(false);
            $table->integer('steps')->default(1);
            $table->integer('status_id')->default(201);

            $table->bigInteger('shop_id')->nullable();
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
            $table->string('reference')->nullable();
            $table->string('provider')->nullable();
            $table->string('currency')->nullable();
            $table->dropColumn('provider_id');
            $table->dropColumn('currency_id');
            $table->dropColumn('payed');
            $table->dropColumn('steps');
            $table->dropColumn('amount_payed');
            $table->dropColumn('status_id');
            $table->dropColumn('name');
            $table->dropColumn('payment_id');
            $table->dropColumn('left_payed');
            $table->dropColumn('method_id');
            $table->dropColumn('shop_id');
        });
    }
};
