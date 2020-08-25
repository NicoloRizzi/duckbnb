<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Apartment;
use App\Review;

class ReviewSeederDef extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Review::truncate();

        $reviewBody = [
            'Appartamento fantastico e servizio eccellete. Consigliatissimo!',
            'Esperienza bellissima, il posto è incredibile e vicinissimo a tanti luoghi da visitare.',
            'TOP! Il gestore è simpaticissimo e super disponibile, anche di notte.',
            'Il posto è molto carino ma il servizio non è il massimo. Consigliato ma può migliorare',
            'Posto carino e servizio nella media. Adeguato al prezzo richiesto',
        ];

        $nRevs = 60;
        $apts = Apartment::all();

        for ($i = 0; $i < $nRevs; $i++) {
            $newReview = new Review();

            $newReview->apartment_id = $apts->random()->id;
            $newReview->user_id = $faker->numberBetween(16, 18);
            $newReview->body = $reviewBody[array_rand($reviewBody)];

            $newReview->save();
        }
    }
}
