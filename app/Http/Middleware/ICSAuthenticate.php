<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;

class ICSAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson() && Auth::user()->is_admin) {
            return redirect('/ics/home');
        }else{
            Auth::logout();
            return redirect('/ics')->withErrors(["You dont have permission to access this site."]);
        }
    }
}
