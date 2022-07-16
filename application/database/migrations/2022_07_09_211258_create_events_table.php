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
        Schema::create('shop_events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('model', 100);
            $table->bigInteger('model_id');
            $table->string('text', 150);
            $table->bigInteger('shop_id');
            $table->string('type');
            $table->string('author_name', 100);

            $table->index(['model', 'model_id']);
            $table->index('shop_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
