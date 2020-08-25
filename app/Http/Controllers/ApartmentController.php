<?php

namespace App\Http\Controllers;
use App\Apartment;
use App\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Sponsorship;
use Illuminate\Support\Carbon; 
class ApartmentController extends Controller
{
    public function show(Apartment $apartment)
    {
        $difference = 0;
        $duration = 0;
        $check = false;
        if(Auth::id() <> $apartment['user_id']) {
            $newView = new View();
            $newView->apartment_id = $apartment->id;
            $newView->ip = '176.32.27.145'; //OCCHIOOOOOOOOOOO
            $saved = $newView->save();
        } 
        else {
            if(($apartment->sponsorships)->isNotEmpty()) {
                foreach ($apartment->sponsorships as $value) {
                    $now = Carbon::now();
                    $sponsorshipDate = $value->pivot->created_at;
                    $difference = $now->diffInHours($sponsorshipDate);
                    $i = 0;
                    $len = count($apartment->sponsorships);
                    if($i == $len - 1) {
                            $duration = $apartment->sponsorships[$i]->duration;
                        }
                }
                if ($difference < $duration ) {
                    $check = true;
                }
            }
        }
        return view("guests.show", compact("apartment", "check", 'difference', 'duration'));
    }
}