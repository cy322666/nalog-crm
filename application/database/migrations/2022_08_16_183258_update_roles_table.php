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
        Schema::rename('roles', 'shop_roles');

        Schema::table('shop_roles', function (Blueprint $table) {

            $table->boolean('is_system')->default(false);

//            $table->dropColumn('guard_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('shop_roles', 'roles');

        Schema::table('roles', function (Blueprint $table) {

            $table->dropColumn('is_system');

//            $table->string('guard_name')->nullable();
        });
    }
};
