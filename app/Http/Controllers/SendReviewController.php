<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Apartment;
use App\User;
use App\Review;

use Illuminate\Http\Request;

class SendReviewController extends Controller
{
    function sendReview(Request $request, Apartment $apartment, Review $review)
    {
        $userSend = Auth::user();

        $this->validate($request, [
            'body' => 'required',
            'from_id' => 'required'
        ]);

        $data = array(
            'body' => $request->body,
            'from_id' => $userSend->id
        );
        
        $newReview = new Review();
        $newReview->apartment_id = $apartment->id;
        $newReview->user_id = $data['from_id'];
        $newReview->body = $data['body'];
        $saved = $newReview->save();
        
        if($saved) {
            // Mail::to($address)->send(new SendReview($data));
            return back()->with('success-review', 'Grazie per la recensione')->with('userSend');
        }
    }
}
