<?php

namespace App\Services;

class ServicesManagementService extends BaseService
{
    public function getAllServices(): array
    {
        try {
            $response = $this->get('/api/v1/services');
            return $response->successful() ? ($response->json('data') ?? []) : [];
        } catch (\Exception) {
            return [];
        }
    }
}
