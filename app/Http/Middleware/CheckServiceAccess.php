<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;

use Closure;
use App\Service;
use Auth;

class CheckServiceAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = $request->route()->action['as'];
        $authorized_service = Service::wherehas('role.user', function ($query){
            $query->where('user_id', auth()->user()->id);
        })->where('route', $url)->first();
        if ($authorized_service) {
            return $next($request);
        }
        abort(403);
    }
}
