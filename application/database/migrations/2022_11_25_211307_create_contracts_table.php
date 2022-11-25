<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();

            $table->dateTime('conclusion_at')->nullable();
            $table->dateTime('execution_at')->nullable();

            $table->integer('region_id')->nullable();
            $table->string('number', 32)->unique();

            $table->integer('contract_type_id')->nullable();
            $table->string('work_type')->nullable();
            $table->string('contract_form')->nullable();

            $table->string('contragent')->nullable();//
            $table->string('partner')->nullable();//

            $table->integer('manager_id')->nullable();
            $table->integer('response_id')->nullable();
            $table->integer('presale_id')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('payed', 12, 2)->nullable();
            $table->decimal('payment_type_id', 12, 2)->nullable();

            //закупки
            //работы
            //документация
            //тех поддержка
            //отправки

            $table->dateTime('date_retest')->nullable();
            $table->dateTime('date_renewal')->nullable();

//            $table->enum('status', ['new', 'processing', 'shipped', 'delivered', 'cancelled'])->default('new');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
};
