<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Cache;
use Carbon\Carbon;

class UserLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $expireTime = Carbon::now()->addHour(3)->addMinute(1); // keep online for 1 min
            Cache::put('is_online'.Auth::user()->id, true, $expireTime);

            //Last Seen
            DB::table('users')->where('id', Auth::user()->id)->update(['last_seen' => Carbon::now()->addHour(3)]);
        }
        return $next($request);
    }
}
