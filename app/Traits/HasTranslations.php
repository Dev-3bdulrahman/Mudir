<?php

namespace App\Traits;

trait HasTranslations
{
    public function getTranslation(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?: app()->getLocale();
        $translations = $this->$field;

        if (is_string($translations)) {
            $translations = json_decode($translations, true) ?? [];
        }

        return $translations[$locale] ?? ($translations[config('app.fallback_locale')] ?? array_shift($translations));
    }
}
