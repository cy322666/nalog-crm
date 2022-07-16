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
        Schema::table('shop_tasks', function (Blueprint $table) {

            $table->dropColumn('uuid');
            $table->dropColumn('employee_id');
            $table->dropColumn('execute');
            $table->dropColumn('count_rescheduled');
            $table->dropColumn('last_failed_at');
            $table->dropColumn('failed');
            $table->dropColumn('entity_id');
            $table->dropColumn('entity_type');
            $table->dropColumn('type_id');

            $table->dateTime('execute_to');
            $table->integer('responsible_id');
            $table->integer('shop_id');
            $table->integer('model_id');
            $table->integer('task_id');
            $table->boolean('is_execute')->default(false);
            $table->string('execute_comment', 200)->nullable();
            $table->string('model_type', 50);
            $table->boolean('is_failed');

            $table->index(['shop_id', 'task_id']);
            $table->index('task_id');
            $table->index('is_execute');
            $table->index('is_failed');
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
        Schema::table('shop_tasks', function (Blueprint $table) {
            $table->dropColumn('execute_to');
            $table->dropColumn('responsible_id');
            $table->dropColumn('shop_id');
            $table->dropColumn('model_id');
            $table->dropColumn('task_id');
            $table->dropColumn('is_execute');
            $table->dropColumn('execute_comment');
            $table->dropColumn('model_type');
            $table->dropColumn('is_failed');
//            $table->dropColumn('type_id');

            $table->string('uuid');
            $table->string('employee_id');
            $table->string('execute');
            $table->string('count_rescheduled');
            $table->string('last_failed_at');
            $table->string('failed');
            $table->string('entity_id');
            $table->string('entity_type');
//            $table->string('type_id');
        });
    }
};
