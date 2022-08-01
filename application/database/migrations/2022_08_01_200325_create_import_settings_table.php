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
        Schema::create('shop_import_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('type');
            $table->integer('import_id');
            $table->boolean('imported')->default(false);
            $table->json('fields')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_import_settings');
    }
};
