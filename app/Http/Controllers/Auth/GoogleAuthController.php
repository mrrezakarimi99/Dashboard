<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Psy\Util\Str;

class GoogleAuthController extends Controller
{
    public function redirect (){
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
         try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('email' , $google_user->email)->first();
            if ($user){
                auth()->loginUsingId($user->id);
            }else{
                $newuser = User::create([
                    'name' => $google_user->name,
                    'email' => $google_user->email,
                    'password' => bcrypt(\Str::random(16))
                ]);
                auth()->loginUsingId($newuser->id);
            }
             return redirect('/home');
        }catch (\Exception $e){
            //TODO show error message
             alert()->error('login socials was not success' , 'Message')->persistent('OK');

             return redirect('/login');
        }
    }

}
