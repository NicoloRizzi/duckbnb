<?php

use App\Apartment;
use App\Review;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;


class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $nRevs = 10;
        $users = User::all();
        $apts = Apartment::all();

        for ($i = 0; $i < $nRevs; $i++) {
            $newReview = new Review();

            $newReview->apartment_id = $apts->random()->id;
            $newReview->user_id = $users->random()->id;
            $newReview->body = $faker->paragraph(6, true);

            $newReview->save();
        }
    }
}
