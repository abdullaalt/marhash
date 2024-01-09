<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\V1\Users\UsersService;
use App\Services\V1\Users\GroupsService;
use App\Services\V1\Rules\RulesService;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
		
		$user = Auth::user();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
	
	public function token(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'string'],
			'password' => ['required', 'string', 'min:6'],
			'device_name' => ['required', 'string']
		]);    
		
		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 401);
		}
		// 1
	 
		$user = User::where('email', $request->email)->first();
		// 2
	 
		if (!$user || !Hash::check($request->password, $user->password)) {
			return response()->json(['error' => ['Неправильный логин или пароль']], 401);
		}
        $us = new UsersService();
        $current_user = $us->getUser($user->id, false);

        $result = [
			'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => $current_user['user']
        ];

        //dd($current_user);
		// 3	 
		return response()->json($result);
		// 4
	}

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
