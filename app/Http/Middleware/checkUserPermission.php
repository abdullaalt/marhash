<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Services\V1\Rules\PermissionsService;

class checkUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $permissions_service;

    public function handle(Request $request, Closure $next, $permission_name, $type, $source_id = false)
    {
        
        $this->permissions_service = new PermissionsService();

        if (!$this->permissions_service->hasAccess($permission_name, $type, $source_id, $request)){
            return response()->json(['errors'=>['Ошибка доступа']], 403);
        }else{
            return $next($request);
        }
        
    }
}
