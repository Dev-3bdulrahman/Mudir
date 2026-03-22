<?php

namespace App\Services;

class PortfolioManagementService extends BaseService
{
    public function getAllPortfolioItems(): array
    {
        try {
            $response = $this->get('/api/v1/portfolio');
            return $response->successful() ? ($response->json('data') ?? []) : [];
        } catch (\Exception) {
            return [];
        }
    }
}
