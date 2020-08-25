<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'apartment_id',
        'user_id',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function apartment()
    {
        return $this->belongsTo("App\Apartment");
    }
}
