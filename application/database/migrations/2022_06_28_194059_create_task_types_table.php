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
        Schema::create('shop_task_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->string('icon');
            $table->string('color');
            $table->bigInteger('shop_id');

            $table->index('shop_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_task_types');
    }
};
