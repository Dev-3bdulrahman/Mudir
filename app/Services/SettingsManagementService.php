<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SettingsManagementService extends BaseService
{
    public function getSettings(): array
    {
        return Cache::remember('site_settings', 300, function () {
            try {
                $response = $this->get('/api/v1/settings');
                return $response->successful() ? ($response->json('data') ?? []) : [];
            } catch (\Exception) {
                return [];
            }
        });
    }

    public function getLocalizedSettings(): array
    {
        $settings = $this->getSettings();
        $locale = app()->getLocale();
        $localized = [];

        foreach ($settings as $key => $value) {
            if (is_array($value) && isset($value[$locale])) {
                $localized[$key] = $value[$locale];
            } else {
                $localized[$key] = $value;
            }
        }

        return $localized;
    }
}
