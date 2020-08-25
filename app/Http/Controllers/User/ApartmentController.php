<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Apartment;
use App\Service;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewApartment;
use App\Mail\DeleteApartment;
use App\Mail\EditApartment;
use Illuminate\Support\Facades\Mail;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $apartments = Apartment::where("user_id", Auth::id())->orderBy("created_at", "desc")->get();
        // $apartments = Apartment::all();


        return view('users.index', compact("apartments"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        return view("users.create", compact("services"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        $data = $request->all();
        $data["user_id"] = Auth::id();
        $data['views'] = 0;

        if (!empty($data["img_url"])) {
            $data["img_url"] = Storage::disk("public")->put("images", $data["img_url"]);
        }

        $newApartment = new Apartment();
        $newApartment->fill($data);
        $saved = $newApartment->save();
        if ($saved) {
            if (!empty($data['services'])) {
                $newApartment->services()->attach($data['services']);
            }
            Mail::to(Auth::user()->email)->send(new NewApartment($newApartment));
            return redirect()->route("user.apartments.show", $newApartment->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $check = false;
        if(Auth::id() <> $apartment['user_id']) {
            $apartment['views'] += 1;
            $saved = $apartment->save();
        }
        return view("guests.show", compact("apartment", "check"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::all();
        return view("users.edit", compact("apartment", 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $request->validate($this->validationRules("sometimes|"));

        $data = $request->all();

        // IMG UPDATE
        if (!empty($data["img_url"])) {

            // delete previous img:
            if (!empty($apartment->img_url)) {
                Storage::disk("public")->delete($apartment->img_url);
            }

            // set new img:
            $data["img_url"] = Storage::disk("public")->put("images", $data["img_url"]);
        } else {
            $data["img_url"] = $apartment->img_url;
        }

        $updated = $apartment->update($data);

        if ($updated) {
            if (!empty($data['services'])) {
                $apartment->services()->sync($data['services']);
            } else {
                $apartment->services()->detach();
            }
            Mail::to(Auth::user()->email)->send(new EditApartment($apartment));
            return redirect()->route("user.apartments.show", $apartment->id);
        }
    }

    public function updateVisibility(Request $request, Apartment $apartment)
    {
        $data = $request->all();
        $updated = $apartment->update($data);

        if($request->input('is_visible') == 0) {
            $visibility = 'hidden';
        } else {
            $visibility = 'published';
        }

        if($updated) {
            return back()->with('visibility', $visibility);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        if (empty($apartment)) {
            abort("404");
        }

        $apartmentId = $apartment->id;
        $apartment->services()->detach();
        $apartment->sponsorships()->detach();
        $deleted = $apartment->delete();

        if ($deleted) {
            // remove img
            if (!empty($apartment->img_url)) {
                Storage::disk("public")->delete($apartment->img_url);
            }
            Mail::to(Auth::user()->email)->send(new DeleteApartment($apartment));
            return redirect()->route("user.apartments.index")->with("apartment_deleted", $apartmentId);
        }
    }

    public function statistics(Apartment $apartment)
    {
        return view('users.statistics', compact('apartment'));
    }

    private function validationRules($type = "")
    {

        $imgRule = $type . "required|image";

        return [
            "title" => "required|max:150",
            "description" => "required|max:1500",
            "img_url" => $imgRule,
            "price" => "required|numeric|max:9999.99",
            "room_qty" => "required|integer|max:255",
            "bathroom_qty" => "required|integer|max:255",
            "bed_qty" => "required|integer|max:255",
            "sqr_meters" => "required|integer|max:65535",
            "is_visible" => "required|boolean",
            "lat" => "between:-90,90|required",
            "lng" => "between:-180,180|required"
        ];
    }
}
