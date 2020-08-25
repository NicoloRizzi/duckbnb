<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        "apartment_id",
        "body",
        "mail_from",
    ];

    public function apartment()
    {
        return $this->belongsTo("App\Apartment");
    }
}
