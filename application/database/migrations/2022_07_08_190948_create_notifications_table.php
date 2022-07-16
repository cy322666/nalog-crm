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
        Schema::create('shop_notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('notifiable_type')->nullable();
            $table->string('title')->nullable();
            $table->string('message')->nullable();
            $table->string('level')->default('info');
            $table->integer('notifiable_id')->nullable();
            $table->string('link')->nullable();
            $table->bigInteger('shop_id');

            $table->boolean('is_read')->default(false);
            $table->dateTime('read_at')->nullable();
            $table->string('type')->default('notificationFeedActions');
            $table->softDeletes();

            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index('is_read');
            $table->index('created_at');
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
        Schema::dropIfExists('notifications');
    }
};
