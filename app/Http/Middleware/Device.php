<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Device {

    protected $guard = 'device'; //same as auth.php
    protected $username = 'kode_perangkat';
    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/login';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $guard = null) {
         if (Auth::guard('device')->guest()) {
             if ($request->ajax() || $request->wantsJson()) {
                 return response('Unauthorized.', 401);
             }
             else {
                 return redirect()->guest('/login');
             }
         }
         return $next($request);
     }

}
