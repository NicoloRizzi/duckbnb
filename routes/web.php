<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Guest
Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search');
Route::post('/search', 'SearchController@search')->name('search.submit');
Route::get('apartments/{apartment}', 'ApartmentController@show')->name('show');

Route::post('sendmessage/send/{apartment}', 'SendMessageController@send')->name('send');
Route::post('sendreview/sendrew/{apartment}', 'SendReviewController@sendReview')->name('sendReview');


Auth::routes();

// User
Route::prefix('user')
    ->name('user.')
    ->namespace('User')
    ->middleware('auth')
    ->group(function () {
        Route::resource('apartments', 'ApartmentController');
        Route::get('apartments/{apartment}/stats', 'ApartmentController@statistics')->name('stats');
        Route::post('apartments/{apartment}/visibility', 'ApartmentController@updateVisibility')->name('apartment.visibility');
        Route::get('apartments/{apartment}/sponsorships','SponsorshipController@index')->name('sponsorships');
        Route::post('apartments/{apartment}/sponsorships/checkout','SponsorshipController@checkout')->name('sponsorships.checkout');

    });
