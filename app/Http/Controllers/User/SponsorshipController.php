<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Apartment;
use App\Sponsorship;
use Braintree;
class SponsorshipController extends Controller
{
    public function index(Apartment $apartment, Sponsorship $sponsorship) {
        $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $sponsorship = Sponsorship::all();

    $token = $gateway->ClientToken()->generate();

    if (Auth::user()->id == $apartment->user_id) {
        return view('users.sponsorships', [
            'token' => $token,
            'apartment' => $apartment,
            'sponsorship' => $sponsorship
        ]);
    } else {
        return back();
    }

    }

    public function checkout (Request $request, Apartment $apartment) {
        $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $amount = $request["amount"];
    $nonce = $request["payment_method_nonce"];

    // Pack id passato con input
    $idPack = $request["pack"];
    
    if($amount == "2.99" && $idPack == "1" || $amount == "5.99" && $idPack == "2" || $amount == "9.99" && $idPack == "3") {

    $result = $gateway->transaction()->sale([
        'amount' => $amount,
        'paymentMethodNonce' => $nonce,
        'customer' => [
            'firstName' => Auth::user()->first_name,
            'lastName' => Auth::user()->last_name,
            'email' => Auth::user()->email,
        ],
        'options' => [
            'submitForSettlement' => true
        ]
]); 

if ($result->success) {

    $apartment->sponsorships()->attach($idPack);

    $transaction = $result->transaction;
    return redirect()->route('show', $apartment->id)->with('success_message', 'Transazione eseguita, ID:'. $transaction->id);
} else {
    $errorString = "";

    foreach($result->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }

/*     $_SESSION["errors"] = $errorString;
    header("Location: " . $baseUrl . "index.php"); */
    return back()->withErrors('An error occurred with the message: ' . $result->message);
} 
    } else {
        return back()->withErrors('Si è verificato un errore');
    }
} 

} 