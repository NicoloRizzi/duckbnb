<?php

use App\Service;
use Illuminate\Database\Seeder;


class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            "WiFi",
            "Posto Macchina",
            "Piscina",
            "Portineria",
            "Sauna",
            "Vista Mare",
            "Aria Condizionata",
            "Fumatori",
            "Prima Colazione"
        ];

        foreach ($services as $service) {
            $newService = new Service();

            $newService->name = $service;
            $newService->save();
        }
    }
}
