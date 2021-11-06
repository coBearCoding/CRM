<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ConfigureMiddleware
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
        //if(Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2) {
        if(Auth::user()->rol_id) {
            return $next($request);
        }else{
            return redirect('solicitudes.index');
        }

    }
}
