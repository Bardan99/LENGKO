<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;

use App\Providers\EmployeeUserProvider;
use Illuminate\Support\ServiceProvider;

class EmployeeAuthProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('employee', function($app, array $config) {
       // Return an instance of             Illuminate\Contracts\Auth\UserProvider...
        return new EmployeeUserProvider($app['employee.connection']);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
