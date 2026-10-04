<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Registers application services (none needed yet)
    public function register(): void
    {
        //
    }

    // Boots application services
    public function boot(): void
    {
        // Railway serves the app over HTTPS through a proxy, so make every
        // generated link and asset URL use https in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
