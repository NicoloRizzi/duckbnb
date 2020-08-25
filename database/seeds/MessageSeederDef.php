<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Apartment;
use App\Message;

class MessageSeederDef extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {   
        Message::truncate();

        $messageBody = [
            'Buonasera, sono interessato alla prenotazione di questo appartamento. Possiamo sentirci telefonicamente?',
            'Buongiorno la contatto per avere maggiori informazioni sull\' appartamento. Quali luoghi di intrattenimanto ci sono nelle vicinanze?',
            'Salve, vorrei un\' informazione. L\' appartamento è libero per tutto il mese di agosto?',
            'Ciao, vorrei prenotare per tutto il mese di luglio. Posso avere un numero di telefono? Ho delle domande e preferirei parlarne a voce',
            'Buonasera, l\' appartamento mi piace molto. È possibile portare animali domestici?'
        ];

        $nMsg = 60;
        $apts = Apartment::all();

        for ($i = 0; $i < $nMsg; $i++) {
            $newMessage = new Message();

            $newMessage->apartment_id = $apts->random()->id;
            $newMessage->body = $messageBody[array_rand($messageBody)];
            $newMessage->mail_from = $faker->email();

            $newMessage->save();
        }
    }
}
