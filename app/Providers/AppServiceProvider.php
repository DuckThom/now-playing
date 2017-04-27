<?php

namespace App\Providers;

use SpotifyWebAPI\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('spotify', function () {
            return new Session(
                config('spotify.client_id'),
                config('spotify.client_secret'),
                config('spotify.redirect_uri')
            );
        });
    }
}
