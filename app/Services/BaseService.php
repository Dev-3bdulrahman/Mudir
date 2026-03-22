<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class BaseService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url', env('EXTERNAL_API_URL', ''));
        $this->apiKey = config('services.external_api.api_key', env('EXTERNAL_API_KEY', ''));
    }

    /**
     * Send GET request
     */
    protected function get(string $endpoint, array $query = []): Response
    {
        return Http::withToken($this->apiKey)
            ->baseUrl($this->baseUrl)
            ->get($endpoint, $query);
    }

    /**
     * Send POST request
     */
    protected function post(string $endpoint, array $data = []): Response
    {
        return Http::withToken($this->apiKey)
            ->baseUrl($this->baseUrl)
            ->post($endpoint, $data);
    }

    /**
     * Send PUT request
     */
    protected function put(string $endpoint, array $data = []): Response
    {
        return Http::withToken($this->apiKey)
            ->baseUrl($this->baseUrl)
            ->put($endpoint, $data);
    }

    /**
     * Send DELETE request
     */
    protected function delete(string $endpoint): Response
    {
        return Http::withToken($this->apiKey)
            ->baseUrl($this->baseUrl)
            ->delete($endpoint);
    }
}
