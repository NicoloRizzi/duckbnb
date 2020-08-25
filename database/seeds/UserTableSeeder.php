<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $nUser = 10;

        for ($i = 0; $i < $nUser; $i++) {
            $newUser = new User();

            $newUser->first_name = $faker->firstName();
            $newUser->last_name = $faker->lastName();
            $newUser->email = $faker->email();
            $newUser->dob = $faker->dateTimeBetween("-80 years", "-18 years");
            $newUser->path_img = "http://unsplash.it/250/250?random&gravity=center";
            $newUser->password = bcrypt("zaninotto");

            $newUser->save();
        }
    }
}
