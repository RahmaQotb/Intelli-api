<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function create(){
        return view('Dashboard.Admin.add');
    }

    public function add(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8|confirmed',
            'is_super_admin'=>'required|boolean',
        ]);
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->is_super_admin =$request->is_super_admin;
        $admin->save();

        return back()->with('success', 'Admin created successfully');

    }

    public function changePasswordForm(){
        return view('Dashboard.Admin.change-password');
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        $admin = Auth::user();

        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->with('fails' , 'The old password is incorrect.');
        }
    
        $admin->password = Hash::make($request->password);
        $admin->save();
    
        return back()->with('success', 'Password changed successfully.');
    }
}
