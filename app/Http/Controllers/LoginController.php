<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'=>'required|email|max:255',
            'password'=>'required|string',
        ]);

        if(Auth::attempt($credentials)) 
        {
            $request->session()->regenerate();
            return redirect()->route('recipes.index');
        } else {
            return back()->withErrors([
                'email' => 'The email or password is incorrect.',
            ]);
        }

    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

}
