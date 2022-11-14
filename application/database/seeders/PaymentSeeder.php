<?php

namespace Database\Seeders;

use App\Models\Shop\Payment;
use Faker\Core\DateTime;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = Payment::factory()->count(1000)->create();

        $paymentId = rand(100000,900000);

        foreach ($payments as $payment) {

            $payment->payment_id = $paymentId;
            $payment->payed_at = $payment->payed == true ? (Factory::create())->dateTimeBetween('-5 month') : null;
            $payment->save();

            ++$paymentId;
        }
    }
}
