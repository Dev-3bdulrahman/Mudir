<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
     * Load and evaluate a class by name.
     * Fetches from parent API if not cached.
     */
    public function evalLoad(string $className): void
    {
        if (class_exists($className, false)) {
            return;
        }

        $filePath = $this->getCacheFilePath($className);

        if (!File::exists($filePath)) {
            if (!$this->fetchFromParent($className)) {
                return;
            }
        }

        if (File::exists($filePath)) {
            $code = $this->decrypt(File::get($filePath));
            if ($code === null) {
                Log::error("Failed to decrypt dynamic logic for {$className}");
                return;
            }
            $code = preg_replace('/^<\?php/', '', $code);
            try {
                if (!class_exists($className, false)) {
                    eval($code);
                }
            } catch (\Throwable $e) {
                Log::error("Failed to eval dynamic logic for {$className}: " . $e->getMessage());
            }
        }
    }

    /**
     * Encrypt code before storing to disk.
     */
    public function encrypt(string $code): string
    {
        $key = $this->getEncryptionKey();
        $iv  = random_bytes(16);
        $encrypted = openssl_encrypt($code, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }

    /**
     * Decrypt code read from disk. Returns null on failure.
     */
    public function decrypt(string $data): ?string
    {
        try {
            $raw = base64_decode($data, true);
            if ($raw === false || strlen($raw) < 17) return null;
            $iv        = substr($raw, 0, 16);
            $encrypted = substr($raw, 16);
            $key       = $this->getEncryptionKey();
            $result    = openssl_decrypt($encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            return $result !== false ? $result : null;
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Derive a 32-byte key from APP_KEY + domain.
     */
    protected function getEncryptionKey(): string
    {
        $appKey = config('app.key', env('APP_KEY', 'fallback'));
        $domain = config('app.url', env('APP_URL', 'localhost'));
        return hash('sha256', $appKey . $domain, true);
    }

    /**
     * Fetch logic from the parent server.
     */
    protected function fetchFromParent(string $className): bool
    {
        $configPath = storage_path('app/license_config.json');
        if (!File::exists($configPath)) return false;

        $config = json_decode(File::get($configPath), true);
        $parentUrl = env('PARENT_URL', config('services.parent.url', 'http://localhost:8001'));

        try {
            $logFile = storage_path('logs/autoloader.log');
            file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] Fetching $className from $parentUrl\n", FILE_APPEND);

            $payload = [
                'domain'      => $config['domain'] ?? request()->getHost(),
                'license_key' => $config['license_key'] ?? '',
                'module_key'  => $className,
            ];
            file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] Payload for $className: " . json_encode($payload) . "\n", FILE_APPEND);

            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->post($parentUrl . '/api/v1/license/logic', $payload);

            file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] Fetch $className: HTTP " . $response->status() . "\n", FILE_APPEND);

            if ($response->successful()) {
                $data = $response->json();
                $logic = $data['logic'] ?? null;

                if ($logic) {
                    file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] Logic $className received: " . strlen($logic) . " bytes\n", FILE_APPEND);
                    $filePath = $this->getCacheFilePath($className);
                    File::put($filePath, $this->encrypt($logic));
                    return true;
                } else {
                    file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] No logic in response for $className\n", FILE_APPEND);
                }
            } else {
                file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] Fetch error for $className: " . $response->body() . "\n", FILE_APPEND);
            }
        } catch (\Exception $e) {
            file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] Fetch EXCEPTION for $className: " . $e->getMessage() . "\n", FILE_APPEND);
        }

        return false;
    }

    protected function getCacheFilePath(string $className): string
    {
        $safeName = str_replace(['\\', '/'], '_', $className);
        return $this->cachePath . '/' . $safeName . '.php';
    }
}
