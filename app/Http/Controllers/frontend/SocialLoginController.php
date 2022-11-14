<?php

namespace App\Http\Controllers\frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function googleGetData()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleRedirectUserData()
    {
        $user = Socialite::driver('google')->user();

        $newUser =  User::updateOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make('password'),
            ]
        );

        $newUser->assignRole('user');
        Auth::login($newUser);
        return redirect('/user/dashboard');
    }



    public function facebookGetData()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookRedirectUserData()
    {
        $user = Socialite::driver('facebook')->stateless()->user();;
        $newUser =  User::updateOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make('password'),
            ]
        );

        $newUser->assignRole('user');
        Auth::login($newUser);
        return redirect('/user/dashboard');
    }
}
