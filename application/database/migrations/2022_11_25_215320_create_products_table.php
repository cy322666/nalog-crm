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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('manufacturer_szi')->nullable();
            $table->string('name_szi')->nullable();
            $table->string('certified_version')->nullable();
            $table->string('certificate_validity_period')->nullable();//
            $table->string('tp_validity_period')->nullable();
            $table->text('note')->nullable();
            $table->decimal('price', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
