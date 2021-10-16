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
    public const HOME = '//127.0.0.1:8100';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->configureUserRoutePatterns();
        $this->configureStaffRoutePatterns();

        $this->routes(function() {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('default', function(Request $request) {
            return Limit::perMinute(100)->by($request->ip());
        });

        RateLimiter::for('auth', function(Request $request) {
            return Limit::perMinute(20)->by($request->ip());
        });

        RateLimiter::for('fcm', function(Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        RateLimiter::for('update', function(Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('subscribe', function(Request $request) {
            return Limit::perMinute(50)->by($request->ip());
        });


        RateLimiter::for('places', function(Request $request) {
            return Limit::perMinute(420)->by($request->ip());
        });

        RateLimiter::for('tables', function(Request $request) {
            return Limit::perMinute(300)->by($request->ip());
        });

        RateLimiter::for('owner', function(Request $request) {
            return Limit::perMinute(100)->by($request->ip());
        });

        RateLimiter::for('staff', function(Request $request) {
            return Limit::perMinute(420)->by($request->ip());
        });
    }

    /**
     * Route patterns that are allowed for route parameters
     *
     * @return void
     */
    protected function configureUserRoutePatterns()
    {
        Route::pattern('placeId', '[0-9]+');
        Route::pattern('notificationTime', '[0-9]+');
    }

    /**
     * Route patterns that are allowed for staff route parameters
     *
     * @return void
     */
    protected function configureStaffRoutePatterns()
    {
        Route::pattern('table', '[0-9]+');
    }
}
