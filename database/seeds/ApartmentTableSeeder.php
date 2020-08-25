<?php

use App\Apartment;
use App\User;
use Faker\Generator as Faker;

use Illuminate\Database\Seeder;

class ApartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $nApts = 100;
        $users = User::all();
        for ($i = 0; $i < $nApts; $i++) {
            $newApt = new Apartment();

            $newApt->user_id = $users->random()->id;
            $newApt->title = $faker->text(50);
            $newApt->description = $faker->text(150);
            $newApt->price = $faker->randomFloat(2, 30, 300);
            $newApt->room_qty = $faker->randomNumber(1);
            $newApt->bathroom_qty = $faker->randomNumber(1);
            $newApt->bed_qty = $faker->randomNumber(1);
            $newApt->sqr_meters = $faker->randomNumber(3);
            $newApt->lat = $faker->latitude(-90, 90);
            $newApt->lng = $faker->longitude();
            $newApt->img_url = "https://picsum.photos/200/300";
            $newApt->views = 0;
            $newApt->is_visible = 1;

            $newApt->save();
        }
    }
}
