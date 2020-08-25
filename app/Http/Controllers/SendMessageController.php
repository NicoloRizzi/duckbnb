<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Apartment;
use App\Message;
use App\Mail\SendMessage;

class SendMessageController extends Controller
{
    function send(Request $request, Apartment $apartment)
    {
        $address = $apartment->user->email;
        
        $this->validate($request, [
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $data = array(
            'email' => $request->email,
            'message' => $request->message,
        );
        
        $newMessage = new Message();
        $newMessage->apartment_id = $apartment->id;
        $newMessage->body = $data['message'];
        $newMessage->mail_from = $data['email'];
        $saved = $newMessage->save();
        
        if($saved) {
            Mail::to($address)->send(new SendMessage($data));
            return back()->with('success', 'Grazie per averci contattato');
        }
    }
}
