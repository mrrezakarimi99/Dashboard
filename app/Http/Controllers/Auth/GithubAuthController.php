<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Psy\Util\Str;

class GithubAuthController extends Controller
{
    public function redirect (){
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {

        try {
            $github_user = Socialite::driver('github')->user();
            $user = User::where('email' , $github_user->email)->first();
            if ($user){
                auth()->loginUsingId($user->id);
            }else{
                $new_user = User::create([
                    'name' => $github_user->name,
                    'email' => $github_user->email,
                    'password' => bcrypt(\Str::random(16))
                ]);
                auth()->loginUsingId($new_user->id);
            }
            return redirect('/home');
        }catch (\Exception $e){
            //TODO show error message
            alert()->error('login socials was not success' , 'Message')->persistent('OK');

            return redirect('/login');
        }
    }
}
