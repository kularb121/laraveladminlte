<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Asset;
use App\Models\Device;
use App\Models\Customer;
use App\Models\Site;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/'; 

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Route::middleware('api')
            //     ->prefix('api')
            //     ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        // Route model binding for UUIDs
        Route::bind('user', fn($value) => User::where('id', $value)->firstOrFail());
        Route::bind('asset', fn($value) => Asset::where('id', $value)->firstOrFail());
        Route::bind('device', fn($value) => Device::where('id', $value)->firstOrFail());
        Route::bind('customer', fn($value) => Customer::where('id', $value)->firstOrFail());
        Route::bind('site', fn($value) => Site::where('id', $value)->firstOrFail());
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}