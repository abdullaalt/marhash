<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

class Limited
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
		
		$user_controller = new UserController();
		
		$is_limited = $user_controller->isUserLimited($user->id);
		
		if ($is_limited){
			$headers = getallheaders();

			$app_id =isset($headers['User-Token']) || isset($headers['user-token']);
			if ($app_id){
				header('Content-Type: application/json');
				return responce()->json(['errors'=>'Доступ к Вашему аккаунту ограничен']);
			}else{
				$request->session()->flash('messages.error', 'Доступ к Вашему аккаунту ограничен');
				return redirect()->back(); 
			}
		}
		
		return $next($request);
    }
}
