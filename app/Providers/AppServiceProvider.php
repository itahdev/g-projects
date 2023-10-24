<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(ContractServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') ||
            $this->app->environment('staging') ||
            $this->app->environment('development')
        ) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
