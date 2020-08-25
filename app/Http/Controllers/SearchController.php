<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Apartment;
use App\Service;

class SearchController extends Controller
{
    public function index()
    {
        $services = Service::all();

        $sponsoredQuery = Apartment::where('is_visible', '<>', 0)->orderBy('views', 'desc')->get();
        $sponsoreds = [];
        $now = Carbon::now();

        foreach ($sponsoredQuery as $sponsored) {
            
            if(($sponsored->sponsorships)->isNotEmpty()) {
                
                $duration = 0;
                $i = 0;
                $len = count($sponsored->sponsorships);
                
                foreach ($sponsored->sponsorships as $e) {
                    if($i == $len - 1) {
                        $duration = $sponsored->sponsorships[$i]->duration;
                    } else {
                        $i++;
                    }
                }
                
                foreach ($sponsored->sponsorships as $sponsorship) {
                    $sponsorshipDate = $sponsorship->pivot->created_at;
                    $difference = $now->diffInHours($sponsorshipDate);
    
                    if($difference < $duration) {
                        $sponsoreds[] = $sponsored;
                    }
                }
            }
        }

        $origin = [
            'lat' => '',
            'lng' => '',
        ];

        return view('guests.search', compact('origin', 'services', 'sponsoreds'));
    }

    public function search(Request $request)
    {   
        $services = Service::all();
        $sponsoredQuery = Apartment::where('is_visible', '<>', 0)->orderBy('views', 'desc')->get();
        $sponsoreds = [];
        $now = Carbon::now();

        foreach ($sponsoredQuery as $sponsored) {
            
            if(($sponsored->sponsorships)->isNotEmpty()) {
                
                $duration = 0;
                $i = 0;
                $len = count($sponsored->sponsorships);
                
                foreach ($sponsored->sponsorships as $e) {
                    if($i == $len - 1) {
                        $duration = $sponsored->sponsorships[$i]->duration;
                    } else {
                        $i++;
                    }
                }
                
                foreach ($sponsored->sponsorships as $sponsorship) {
                    $sponsorshipDate = $sponsorship->pivot->created_at;
                    $difference = $now->diffInHours($sponsorshipDate);
    
                    if($difference < $duration) {
                        $sponsoreds[] = $sponsored;
                    }
                }
            }
        }

        

        $origin = [
            'lat' => $request->lat,
            'lng' => $request->lng,
        ];

        if (!empty($request)) {
            $ids = $request->id[0];
            $array = explode(',', $ids);

            $apartments = Apartment::whereIn("id", $array)->where('is_visible', '<>', 0)->get();

            return view('guests.search', compact('apartments', 'origin', 'services', 'sponsoreds'));
        } else {
            return view('guests.search', compact('services'));
        }
    }
}
