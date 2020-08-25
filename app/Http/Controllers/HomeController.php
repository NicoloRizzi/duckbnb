<?php

namespace App\Http\Controllers;
use App\Apartment;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $res = Apartment::where('is_visible', '<>', 0)->orderBy('views', 'desc')->get();
        $now = Carbon::now();

        $apartments = [];

        foreach ($res as $apartment) {
            
            if(($apartment->sponsorships)->isNotEmpty()) {
                
                $duration = 0;
                $i = 0;
                $len = count($apartment->sponsorships);
                
                foreach ($apartment->sponsorships as $e) {
                    if($i == $len - 1) {
                        $duration = $apartment->sponsorships[$i]->duration;
                    } else {
                        $i++;
                    }
                }
                
                foreach ($apartment->sponsorships as $sponsorship) {
                    $sponsorshipDate = $sponsorship->pivot->created_at;
                    $difference = $now->diffInHours($sponsorshipDate);
    
                    if($difference < $duration) {
                        $apartments[] = $apartment;
                    }
                }
            }
        }

        return view('guests.index', compact('apartments'));
    }
}
