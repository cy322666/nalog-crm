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
        Schema::create('shop_imports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name')->nullable();
            $table->integer('type')->nullable();
            $table->integer('count_rows')->nullable();
            $table->integer('count_imported')->default(0);
            $table->boolean('is_completed')->default(false);
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
        Schema::dropIfExists('imports');
    }
};
