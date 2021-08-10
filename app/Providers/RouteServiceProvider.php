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
        RateLimiter::for('api', function(Request $request) {
            return Limit::perMinute(5)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Route patterns that are allowed for route parameters
     *
     * @return void
     */
    protected function configureUserRoutePatterns()
    {
        Route::pattern('cafeId', '[0-9]+');
        Route::pattern('notificationTime', '[0-9]+');
        Route::pattern('start', '[0-9]+');
        Route::pattern('numberOfCafes', '[0-9]+');
        Route::pattern('serialNumber', '[0-9]+');
        Route::pattern('driver', '[a-z]+');
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
