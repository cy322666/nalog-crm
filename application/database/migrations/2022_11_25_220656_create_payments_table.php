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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->dateTime('payed_at')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('payed', 12, 2)->nullable();
            $table->float('nds')->nullable();
            $table->string('purpose_payment')->nullable();
            $table->integer('contragent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
