<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapWebRoutes();
            $this->mapApiV1Routes();
        });
    }

    /**
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * @return void
     */
    protected function mapApiV1Routes(): void
    {
        Route::middleware('api')
            ->prefix('api/v1')
            ->group(base_path('routes/api.php'));
    }

    /**
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', static function (Request $request) {
            return Limit::perMinute(180)->by($request->user()?->id ?: $request->ip());
        });
    }
}
