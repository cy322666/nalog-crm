<?php

namespace Database\Seeders;

use App\Models\Shop\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = Service::factory()->count(500)->create();

        $latest = Service::query()->latest()->first();

        $serviceId = $latest ? $latest->service_id++ : 1;

        foreach ($services as $service) {

            $shop = $service->shop;

            $service->creator_id = $shop->users->random()->id;
            $service->service_id = $serviceId;
            $service->save();

            ++$serviceId;

            $service->orders()->attach($shop->orders->random()->id);
        }
    }
}
