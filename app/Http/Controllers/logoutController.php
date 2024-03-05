<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class logoutController extends Controller
{
    public function logout(){
        
        Session::flush();
        Auth::logout();
      return redirect()->route('login');
    }
}
