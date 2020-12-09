<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('/auth/google' , 'Auth\GoogleAuthController@redirect')->name("auth.google");
Route::get('/auth/google/callback' , 'Auth\GoogleAuthController@callback');

Route::get('/auth/github' , 'Auth\GithubAuthController@redirect')->name("auth.github");
Route::get('/auth/github/callback' , 'Auth\GithubAuthController@callback');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/secret' , function (){
    return "readasdf" ;
})->middleware([ 'auth' , 'password.confirm' ]);
Route::middleware('auth')->group(function (){
    Route::get("profile" , 'ProfileController@index')->name("profile.index");
    Route::get("profile/twofactor" , 'ProfileController@managetwofactor')->name("profile.twofactor");
    Route::post("profile/twofactor" , 'ProfileController@Postmanagetwofactor');

    Route::get('profile/twofactor/phone' , 'ProfileController@getphoneVerify')->name('profile.TwoFactorPhone');
    Route::post('profile/twofactor/phone' , 'ProfileController@postphoneVerify');
});

