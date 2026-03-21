<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckLicense
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip license check for public routes and installation routes
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        $config = $this->getLicenseConfig();

        if (!$config) {
            return redirect()->route('install.index');
        }

        // Check cache first (valid for 1 hour by default)
        $licenseStatus = Cache::get('license_status');

        if (!$licenseStatus) {
            $licenseStatus = $this->verifyWithParent($config);
            if (is_array($licenseStatus) && ($licenseStatus['status'] === 'active' || $licenseStatus['status'] === 'grace_period')) {
                Cache::put('license_status', $licenseStatus, now()->addHour());
            }
        }

        if (!$licenseStatus || in_array($licenseStatus['status'], ['invalid', 'expired', 'suspended'])) {
            return response()->view('errors.license', [
                'status' => $licenseStatus['status'] ?? 'invalid',
                'message' => $licenseStatus['message'] ?? 'License verification failed.',
            ], 403);
        }

        return $next($request);
    }

    protected function shouldSkip(Request $request): bool
    {
        $publicPaths = [
            '/',
            'install*',
            'api/public*',
        ];

        foreach ($publicPaths as $path) {
            if ($request->is($path)) {
                return true;
            }
        }

        return false;
    }

    protected function getLicenseConfig()
    {
        $configPath = storage_path('app/license_config.json');
        if (!file_exists($configPath)) {
            return null;
        }

        return json_decode(file_get_contents($configPath), true);
    }

    protected function verifyWithParent($config)
    {
        try {
            $parentUrl = config('services.parent.url', 'http://localhost:8000');
            
            $response = Http::post($parentUrl . '/api/v1/license/check', [
                'domain' => $config['domain'],
                'license_key' => $config['license_key'],
                'product_slug' => $config['product_slug'],
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return ['status' => 'invalid', 'message' => 'Cannot connect to licensing server.'];
        } catch (\Exception $e) {
            return ['status' => 'invalid', 'message' => 'Licensing server connection error.'];
        }
    }
}
