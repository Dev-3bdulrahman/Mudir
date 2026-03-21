<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardCodeService
{
    public function getDashboardCode()
    {
        $configPath = storage_path('app/license_config.json');
        if (!file_exists($configPath)) {
            return null;
        }

        $config = json_decode(file_get_contents($configPath), true);
        
        // Cache the dashboard code for a specific version/subscriber
        $cacheKey = 'dashboard_code_' . $config['license_key'];
        
        return Cache::remember($cacheKey, now()->addDay(), function () use ($config) {
            return $this->fetchFromParent($config);
        });
    }

    protected function fetchFromParent($config)
    {
        try {
            $parentUrl = config('services.parent.url', 'http://localhost:8000');
            $response = Http::post($parentUrl . '/api/v1/license/dashboard', [
                'domain' => $config['domain'],
                'license_key' => $config['license_key'],
            ]);

            if ($response->successful()) {
                return $response->json('dashboard_code');
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function clearCache()
    {
        $configPath = storage_path('app/license_config.json');
        if (file_exists($configPath)) {
            $config = json_decode(file_get_contents($configPath), true);
            Cache::forget('dashboard_code_' . $config['license_key']);
            Cache::forget('license_status');
        }
    }
}
