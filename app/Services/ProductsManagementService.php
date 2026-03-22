<?php

namespace App\Services;

class ProductsManagementService extends BaseService
{
    public function getAllProducts(): array
    {
        try {
            $response = $this->get('/api/v1/products');
            return $response->successful() ? ($response->json('data') ?? []) : [];
        } catch (\Exception) {
            return [];
        }
    }
}
