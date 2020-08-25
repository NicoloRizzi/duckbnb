<?php

use App\Sponsorship;
use Illuminate\Database\Seeder;

class SponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors = [
            [
                "price" => 2.99,
                "duration" => 24
            ],
            [
                "price" => 5.99,
                "duration" => 72
            ],
            [
                "price" => 9.99,
                "duration" => 144
            ],

        ];

        foreach ($sponsors as $sponsor) {
            $newSponsorhip = new Sponsorship();
            $newSponsorhip->price = $sponsor["price"];
            $newSponsorhip->duration = $sponsor["duration"];

            $newSponsorhip->save();
        }
    }
}
