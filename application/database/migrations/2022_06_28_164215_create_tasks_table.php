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
        Schema::create('shop_tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->uuid()->nullable();
            $table->string('title');
            $table->string('text');
            $table->string('entity_id');
            $table->string('entity_type');
            $table->bigInteger('employee_id');
            $table->bigInteger('type_id');
            $table->bigInteger('created_employee_id');
            $table->dateTime('execute_at');
            $table->boolean('execute')->default(false);
            $table->softDeletes();

            $table->index('type_id');
            $table->index('execute');
            $table->index('created_employee_id');
            $table->index('execute_at');
            $table->index('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_tasks');
    }
};
