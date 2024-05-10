<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extensions\TokenUserProvider;
use Illuminate\Support\Facades\Auth;

class TokenAuthProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('token-driver', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new TokenUserProvider($app['hash'], $config['model']);
        });
    }
}
