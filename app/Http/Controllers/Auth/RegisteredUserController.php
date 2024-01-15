<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use App\Models\Content;
use App\Services\V1\Users\UsersService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
		
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
//dd($request);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'uuid' => (string) Str::uuid(),
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        Auth::login($user);

        $us = new UsersService();
        $current_user = $us->getUser($user->id, false);

        $result = [
			'token' => $user->createToken('mobile')->plainTextToken,
            'user' => $current_user['user']
        ];

        return response()->json($result);
    }
}
