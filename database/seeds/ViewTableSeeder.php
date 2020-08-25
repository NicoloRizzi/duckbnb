<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Apartment;
use App\View;

class ViewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        View::truncate();

        $apts = Apartment::all();
        $iterations = 500;

        for ($i=0; $i < $iterations; $i++) { 
            $newView = new View();
         
            $newView->apartment_id = $apts->random()->id;
            $newView->ip = '176.32.27.145';
            $newView->created_at = $faker->dateTimeBetween('-6 months', 'now');

            $newView->save();
        }
    }
}
