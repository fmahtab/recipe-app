<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): View
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email',
            'password'=>'required|string|min:8|confirmed',
        ]);
        User::create([
            'name'=>$validated['name'],
            'email'=>$validated['email'],
            'password'=>Hash::make($validated['password']),
        ]);
        return view('auth.store');
    }

}

