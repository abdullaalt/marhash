<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Services\V1\Logs\LogsService;

class LogsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $logs_service;

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response){

        $this->logs_service = new LogsService($request);

        $this->logs_service->register($request, $response);

    }
}
