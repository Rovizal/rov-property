<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request)
    {
        // User::create($request->validate([
        //     'name'      => 'required',
        //     'email'     => 'required|email|unique:users',
        //     'password'  => 'required|min:8|confirmed' //IF confirmed active THAN LARAVEL EXPECT ANOTHER DATA SENT CALLED password_confirmation
        // ]));

        $user = User::create($request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed' //IF confirmed active THAN LARAVEL EXPECT ANOTHER DATA SENT CALLED password_confirmation
        ]));

        // $user->password = Hash::make($user->password);
        // $user->save();

        Auth::login($user);
        event(new Registered($user));
        return redirect()->route('listing.index')->with('success', 'Account Created');
    }
}
