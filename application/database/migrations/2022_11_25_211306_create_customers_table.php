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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('inn')->nullable();
            $table->string('kpp')->nullable();
            $table->string('ogrn')->nullable();
            $table->integer('region_id')->nullable();
            $table->string('address_real')->nullable();
            $table->string('address_legal')->nullable();
            $table->integer('responsible_id')->nullable();
            $table->boolean('unscrupulous')->default(false);
            $table->boolean('debtor')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
