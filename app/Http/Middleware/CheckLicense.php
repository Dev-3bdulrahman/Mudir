<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckLicense
{
    /**
     * Handle an incoming request.
     * Only blocks admin routes. Public/frontend routes pass through freely.
     */
    public function handle(Request $request, Closure $next)
    {
        $licenseStatus = $this->getLicenseStatus();

        if ($licenseStatus['valid'] !== true) {
            return response()->view('errors.license', [
                'status' => $licenseStatus['status'] ?? 'invalid',
                'message' => $licenseStatus['message'] ?? 'Your license is inactive. Please renew to access the dashboard.',
                'support_info' => $licenseStatus['support_info'] ?? [],
            ], 403);
        }

        return $next($request);
    }

    /**
     * Get license status — cached for 10 minutes to avoid hammering the parent.
     */
    protected function getLicenseStatus(): array
    {
        return Cache::remember('license_status', now()->addMinutes(10), function () {
            return $this->checkWithParent();
        });
    }

    /**
     * Call the parent project's API to verify the license.
     */
    protected function checkWithParent(): array
    {
        $configPath = storage_path('app/license_config.json');

        if (!file_exists($configPath)) {
            return ['valid' => false, 'status' => 'not_configured', 'message' => 'License not configured. Please run the installer.'];
        }

        $config = json_decode(file_get_contents($configPath), true);
        $parentUrl = config('services.parent.url', 'http://localhost:8001');

        try {
            $response = Http::timeout(10)
                ->withHeaders(['Accept' => 'application/json'])
                ->post($parentUrl . '/api/v1/license/check', [
                    'domain'       => $config['domain'] ?? request()->getHost(),
                    'license_key'  => $config['license_key'] ?? '',
                    'product_slug' => $config['product_slug'] ?? '',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (($data['status'] ?? '') === 'active') {
                    return ['valid' => true, 'status' => 'active'];
                }
                return [
                    'valid' => false, 
                    'status' => $data['status'] ?? 'invalid', 
                    'message' => $data['message'] ?? 'License is not active.',
                    'support_info' => $data['support_info'] ?? []
                ];
            }

            Log::warning('License check failed: HTTP ' . $response->status(), ['body' => $response->body()]);
            $errorData = $response->json();
            return [
                'valid' => false, 
                'status' => 'error', 
                'message' => 'Could not verify license. Please try again later.',
                'support_info' => $errorData['support_info'] ?? []
            ];

        } catch (\Exception $e) {
            Log::error('License check exception: ' . $e->getMessage());
            return [
                'valid' => false, 
                'status' => 'unreachable', 
                'message' => 'Cannot reach license server. Please check your internet connection.',
                'support_info' => [
                    'email' => 'support@3bdulrahman.com',
                    'whatsapp' => '+966500000000'
                ]
            ];
        }
    }
}
