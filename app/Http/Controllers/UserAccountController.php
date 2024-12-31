<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends Controller
{
    public function create() {
        return inertia('Auth/Create');
    }

    public function store (Request $request ) {

        $user = User::create($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]));

        // $user->password = Hash::make($user->password);
        // $user->save();

        Auth::login($user);

        return redirect()->route('listing.index')
            ->with('success', 'Account created!');
    }
}
