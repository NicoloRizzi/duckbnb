<?php

use App\Apartment;
use App\Message;

use Faker\Generator as Faker;

use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $nMsg = 10;
        $apts = Apartment::all();

        for ($i = 0; $i < $nMsg; $i++) {
            $newMessage = new Message();

            $newMessage->apartment_id = $apts->random()->id;
            $newMessage->body = $faker->text(100);
            $newMessage->mail_from = $faker->email();

            $newMessage->save();
        }
    }
}
