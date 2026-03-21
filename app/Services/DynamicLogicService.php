<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class DynamicLogicService
{
    protected string $cachePath;

    public function __construct()
    {
        $this->cachePath = storage_path('app/dynamic_logic');
        if (!File::exists($this->cachePath)) {
            File::makeDirectory($this->cachePath, 0755, true);
        }
    }

    /**
     * Load and execute logic via eval().
     */
    public function evalLoad(string $className): void
    {
        $filePath = $this->getCacheFilePath($className);

        if (!File::exists($filePath)) {
            if (!$this->fetchFromParent($className)) {
                throw new \Exception("Failed to fetch dynamic logic for {$className}");
            }
        }

        $code = File::get($filePath);
        // Remove <?php tag for eval
        $code = preg_replace('/^<\?php/', '', $code);
        
        eval($code);
    }

    /**
     * Fetch logic from the parent server.
     */
    protected function fetchFromParent(string $className): bool
    {
        $configPath = storage_path('app/license_config.json');
        if (!File::exists($configPath)) {
            return false;
        }

        $config = json_decode(File::get($configPath), true);
        $parentUrl = config('services.parent.url', 'http://localhost:8000');

        \Log::info("Fetching dynamic logic for: {$className}");

        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->post($parentUrl . '/api/v1/license/logic', [
                    'domain' => $config['domain'],
                    'license_key' => $config['license_key'],
                    'module_key' => str_replace('Core', '', $className),
                ]);

            \Log::info("Parent response status: " . $response->status());

            if ($response->successful()) {
                $data = $response->json();
                $logic = $data['logic'];

                // Handle Shell Inheritance: Rename fetched class if needed
                if (str_ends_with($className, 'Core')) {
                    $baseClassName = substr(basename(str_replace('\\', '/', $className)), 0, -4);
                    $logic = str_replace("class {$baseClassName}", "class {$baseClassName}Core", $logic);
                }

                $this->saveToCache($className, $logic);
                return true;
            }
        } catch (\Exception $e) {
            \Log::error("Failed to fetch dynamic logic for {$className}: " . $e->getMessage());
        }

        return false;
    }

    /**
     * Save fetched logic to local file cache.
     */
    protected function saveToCache(string $className, string $code): void
    {
        $filePath = $this->getCacheFilePath($className);
        File::ensureDirectoryExists(dirname($filePath));
        File::put($filePath, $code);
    }

    /**
     * Get the local cache file path for a class.
     */
    protected function getCacheFilePath(string $className): string
    {
        $fileName = str_replace('\\', '_', $className) . '.php';
        return $this->cachePath . '/' . $fileName;
    }

    /**
     * Clear the dynamic logic cache.
     */
    public function clearCache(): void
    {
        File::cleanDirectory($this->cachePath);
    }
}
