<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Register Dynamic Logic Autoloader
        spl_autoload_register(function ($class) {
            // Only handle classes within our application namespace
            if (str_starts_with($class, 'App\\')) {
                $logicService = app(\App\Services\DynamicLogicService::class);
                $logicService->load($class);
            }
        });
    }
}
