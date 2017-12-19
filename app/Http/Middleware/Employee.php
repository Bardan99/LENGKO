<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Employee {

    protected $guard = 'employee'; //same as auth.php
    protected $username = 'kode_pegawai';
    protected $redirectTo = '/dashboard';
    protected $redirectAfterLogout = '/dashboard/login';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $guard = null) {
         if (Auth::guard('employee')->guest()) {
             if ($request->ajax() || $request->wantsJson()) {
                 return response('Unauthorized.', 401);
             }
             else {
                 return redirect()->guest('/dashboard/login');
             }
         }
         return $next($request);
     }

}
