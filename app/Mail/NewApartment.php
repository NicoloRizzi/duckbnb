<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Apartment;

class NewApartment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *  Apartment instance
    */
    private $apartment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Apartment $apartment)
    {
        $this->apartment = $apartment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('index@duckbnb.com')
                    ->markdown('mail.new-apartment')
                    ->with([
                        'title' => $this->apartment->title,
                        'description' => $this->apartment->description
                    ]);
    }
}
