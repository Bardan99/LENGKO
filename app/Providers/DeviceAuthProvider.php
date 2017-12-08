<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;

use App\Providers\DeviceUserProvider;
use Illuminate\Support\ServiceProvider;

class DeviceAuthProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('device', function($app, array $config) {
       // Return an instance of             Illuminate\Contracts\Auth\UserProvider...
        return new DeviceUserProvider($app['device.connection']);
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
