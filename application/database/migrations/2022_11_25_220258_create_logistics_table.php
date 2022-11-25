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
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('shipping_method')->nullable();
            $table->string('shipping_price')->nullable();
            $table->dateTime('shipping_date')->nullable();
            $table->text('note')->nullable();
            $table->string('recipient')->nullable();
            $table->string('color')->nullable();
            $table->string('invoice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistics');
    }
};
