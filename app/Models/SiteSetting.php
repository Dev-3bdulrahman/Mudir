<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if (!$setting) return $default;

        $value = $setting->value;
        if (is_array($value)) {
            return $value[app()->getLocale()] ?? ($value[config('app.fallback_locale')] ?? array_shift($value));
        }

        return $value;
    }
}
