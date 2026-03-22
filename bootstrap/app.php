<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// ─── Dynamic Logic Autoloader (EARLY & PREPENDED) ───────────────────────────
spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'App\\') && (str_contains($class, 'Services\\') || str_contains($class, 'Livewire\\')) 
        && !class_exists($class, false)) {
        
        try {
            $logicService = new \App\Services\DynamicLogicService();
            $logicService->evalLoad($class);
        } catch (\Throwable $e) {
            // Silently fail to let other autoloaders take over if we didn't define it
        }
    }
}, true, true);

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'license' => \App\Http\Middleware\CheckLicense::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
