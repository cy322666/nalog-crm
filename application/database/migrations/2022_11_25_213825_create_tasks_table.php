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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->bigInteger('response_id')->nullable();
            $table->bigInteger('creator_id')->nullable();
            $table->dateTime('execute_at')->nullable();
            $table->dateTime('failed_at')->nullable();
            $table->boolean('execute')->default(false);
            $table->softDeletes();

            $table->json('observers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
