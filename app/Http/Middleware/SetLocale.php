<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     * Sets the application locale based on session context.
     */
    public function handle(Request $request, Closure $next)
    {
        // Decide which session key to use based on the path
        $scope = str_contains($request->path(), 'admin') ? 'locale_dashboard' : 'locale_landing';
        
        $locale = Session::get($scope, 'en');
        
        if (in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
