<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    // protected $namespace = 'App\\Http\\Controllers';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::name('api')
                ->domain(sprintf('api.%s', config('app.domain')))
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->domain(sprintf('docs.%s', config('app.domain')))
                ->namespace($this->namespace)
                ->name('docs.')
                ->group(base_path('routes/docs.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->domain(config('app.domain'))
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
