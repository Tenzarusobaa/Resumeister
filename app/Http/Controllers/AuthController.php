<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Agency;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        $user = User::where('username', $credentials['username'])
                    ->where('password', $credentials['password'])
                    ->first();
        
        if ($user) {
            Auth::login($user);
            return redirect('/jobs');
        }
        
        $agency = Agency::where('username', $credentials['username'])
                    ->where('password', $credentials['password'])
                    ->first();
        
        if ($agency) {
            Auth::guard('agency')->login($agency);
            return redirect('/agency');
        }
        
        return redirect('/login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}