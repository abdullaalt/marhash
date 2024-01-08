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
            'fio' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'string', 'max:6']
        ]);
		
//dd($request);
        $user = User::create([
            'phone' => $request->phone,
            'uuid' => (string) Str::uuid(),
            'password' => Hash::make($request->password)
        ]);
		
		$content = new Content();
		$card = $content->getCardByNumber($request->phone);
		if (!$card){
			$card = array();
			$values = explode(' ', $request->fio);
			$card['user_id'] = $user->id;
			$card['surname'] = $values[0];
			$card['name'] = isset($values[1]) ? $values[1] : 'Без имени';
			$card['patronymic'] = isset($values[2]) ? $values[2] : 'Без отчества';
			if (!empty($request->born)){
				$card['birthdate'] = date('Y-m-d', strtotime($request->born));
			}else{
				$card['birthdate'] = 2000;
			}
			$card['phone'] = $request->phone;
			$card['target'] = 9;
			$card['gender'] = $request->gender;
			$card['city_id'] = 1;
			$card['uuid'] = (string) Str::uuid();
						
			$card_id = $content->addUserCard($card);
		}

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
