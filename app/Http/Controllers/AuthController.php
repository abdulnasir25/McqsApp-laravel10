<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function studentDashboard()
    {
        return view('student.dashboard');
    }

    public function register()
    {
        // add check to see, if user is logged & is admin or student
        if(Auth::user() && Auth::user()->is_admin) {
            return redirect('/admin/dashboard');
        } elseif(Auth::user() && !Auth::user()->is_admin) {
            return redirect('/student/dashboard');
        }

        return view('register');
    }

    public function saveRegister(Request $request)
    {
        // validate the request data
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|unique:users|max:50',
            'password' => 'required|confirmed|min:6'
        ]);

        // create obj of user model
        $user = new User;
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->route('loadLogin')->with('success', 'Registration successfull. Please login here to continue!');
    }

    public function loadLogin()
    {
        // add check to see, if user is logged & is admin or student
        if(Auth::user() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif(Auth::user() && !Auth::user()->is_admin) {
            return redirect()->route('student.dashboard');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // separate email and pass from the request
        // for this purpose we will use: only() method
        $user_credentials = $request->only('email', 'password');

        // for user verification, pass the $user_crendentials to Auth->attempt() method
        if (Auth::attempt($user_credentials)) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        } else {
            return back()->with('error', 'Email or Password is incorrect!');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/login');
    }
}
