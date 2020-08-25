<?php

namespace App\Http\Controllers\Api;

use App\Apartment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function stats(Apartment $apartment)
    {
        $data = Apartment::with('views')->find($apartment->id);

        $res = [
            'error' => '',
            'response' => $data
        ];

        return response()->json($res);
    }
    
    public function filter(Request $request)
    {   
        $res = [
            'error' => '',
            'response' => []
        ];

        $ids = explode(',', $request->id);
        $minRooms = $request->rooms;
        $minBeds = $request->beds;
        $collection = $this->collectApts($ids, $minRooms, $minBeds);
        
        if($request->services <> 'all') {

            $services = explode(',', $request->services);

            if( $collection->isNotEmpty() ) {
                foreach ($collection as $apartment) {
                    
                    $array = [];

                    foreach ($apartment->services as $service) {
                        $array[] = $service['id'];
                    }

                    if(count($services) <= count($array)) {
                        $diff = array_diff($services, $array);
                        
                        if(empty($diff)) {
                            $res['response'][] = $apartment;
                        }
                    }
                }
            }
          
        } else {
            if($collection->isNotEmpty()) {
                foreach($collection as $apartment) {
                    $res['response'][] = $apartment;
                }
            }
        }

        return response()->json($res);
    }

    private function collectApts($ids, $minRooms, $minBeds) 
    {
        return Apartment::with('services', 'reviews')
        ->whereIn('id', $ids)
        ->where([
            ['room_qty', '>=', $minRooms],
            ['bed_qty', '>=', $minBeds],
            ['is_visible', '=', 1]
            ])
        ->get();
    }
}
