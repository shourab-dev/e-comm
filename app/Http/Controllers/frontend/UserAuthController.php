<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{

    function userLogin()
    {
        return view('frontend.auth.login');
    }
    function userRegister()
    {
        return view('frontend.auth.register');
    }


    function dashboard()
    {
        return view('frontend.dashboard.user_dashboard');
    }
}
