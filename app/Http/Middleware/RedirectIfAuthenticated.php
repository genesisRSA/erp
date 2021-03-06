<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = User::find(Auth::user()->id);
            $user->api_token = Str::random(60);
            $user->save();
            
            if ($guard == 'ics') {
                return redirect('/ics/home');
            }else if ($guard == 'dcs') {
                return redirect('/reiss/home');
            }else if ($guard == 'web') {
                return redirect('/hris/home');
            }else if ($guard == 'reiss') {
                return redirect('/reiss/home');
            }
        }

        return $next($request);
    }
}
