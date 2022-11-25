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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('account_number')->nullable();
            $table->dateTime('account_date')->nullable();
            $table->boolean('goods_received')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('principal_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->integer('manager_id')->nullable();
            $table->integer('response_id')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->float('nds')->nullable();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
