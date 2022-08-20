<?php

namespace Database\Seeders;

use App\Models\Shop\Payment;
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

        $latest = Payment::query()->latest()->first();

        $paymentId = $latest->payment_id;

        foreach ($payments as $payment) {

            $payment->payment_id = $paymentId;
            $payment->payed = $payment->status->type == 'success';
            $payment->order_id = $payment->shop->orders->random()->id;
            $payment->creator_id = $payment->shop->users->random()->id;
            $payment->lost_at = $payment->status->status_id == 'lost' ? $this->faker->dateTimeBetween('-5 month') : null;
            $payment->payed_at = $payment->payed == true ? $this->faker->dateTimeBetween('-5 month') : null;
            $payment->save();

            $paymentId++;
        }
    }
}
