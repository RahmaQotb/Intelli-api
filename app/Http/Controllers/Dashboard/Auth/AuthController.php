<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLogin(){
        return view('Dashboard.Auth.Login');
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'guard' => 'required|in:brand_admin,admin',
        ]);
        $guard = $validated['guard'];
        $credentials = $request->only('email', 'password');

        if (Auth::guard($guard)->attempt($credentials)) {
            return redirect()->route('dashboard.index')->with('success','Login Successfully !');
        }
        
        return redirect()->back()->with('fails', 'Invalid Credentials!');

    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('dashboard.auth.login_form')->with('success', 'Logged Out .');
    }
}
