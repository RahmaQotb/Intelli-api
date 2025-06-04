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

          // Logout from all guards first to prevent session conflicts

        Auth::guard('admin')->logout();
        Auth::guard('brand_admin')->logout();

        // Clear the session completely
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();

        if (Auth::guard($guard)->attempt($credentials)) {
            session(['active_guard' => $guard]);
            return redirect()->route('dashboard.index')->with('success','Login Successfully !');
        }

        return redirect()->back()->with('fails', 'Invalid Credentials!');

    }

    public function logout(Request $request){
        $guards = get_all_guards();
        foreach($guards as $guard){
            Auth::guard($guard)->logout();
        }
        // Auth::guard('brand_admin')->logout();

        // Clear the session completely
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();

        return redirect()->route('dashboard.auth.login_form')->with('success', 'Logged Out .');
    }
}
