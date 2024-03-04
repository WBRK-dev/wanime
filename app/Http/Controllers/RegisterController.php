<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\Registrations;
use App\Models\User;

class RegisterController extends Controller
{
    function show() {


        return view("account.register");
    }

    function register(Request $request) {

        $credentials = $request->validate([
            'name' => ['required', 'min:3', 'max:12'],
            'email' => ['required', 'email', 'string', 'lowercase', 'max:255', 'unique:'.Registrations::class, 'unique:'.User::class],
            'password' => ['required', 'min:8', 'max:32'],
            'passwordagain' => ['required', 'same:password'],
        ]);
        
        Registrations::insert([
            "name"=>$credentials["name"],
            "email"=>$credentials["email"],
            "password"=>Hash::make($credentials["password"]),
        ]);

        return view('account.registration_succesfull');
    }
}
