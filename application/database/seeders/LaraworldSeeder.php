<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraworldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //вроде надо

        // Seed the countries
        $this->call(\Database\Seeders\CountriesTableSeeder::class);

        // Seed the Time Zones
        $this->call(\Database\Seeders\TimeZonesTableSeeder::class);

        // Seed the Languages
        $this->call(\Database\Seeders\LanguagesTableSeeder::class);

        $this->call(\Database\Seeders\CurrencySeeder::class);

        $this->command->info('Справочники языки + зоны + валюты созданы');
    }
}
