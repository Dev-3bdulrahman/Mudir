<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'name',
        'email',
        'domain',
        'licensed_product_id',
        'license_key',
        'child_app_key',
        'encrypted_modules',
        'status',
        'expires_at',
        'grace_period_days',
    ];

    protected $hidden = ['child_app_key', 'encrypted_modules'];

    protected $casts = [
        'expires_at'        => 'datetime',
        'grace_period_days' => 'integer',
    ];

    // ─── Encrypt child_app_key at rest using parent APP_KEY ──────────────────

    public function setChildAppKeyAttribute(string $value): void
    {
        $key = hash('sha256', config('app.key'), true);
        $iv  = random_bytes(16);
        $enc = openssl_encrypt($value, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $this->attributes['child_app_key'] = base64_encode($iv . $enc);
    }

    public function getChildAppKeyAttribute(?string $value): ?string
    {
        if (!$value) return null;
        try {
            $raw    = base64_decode($value, true);
            $key    = hash('sha256', config('app.key'), true);
            $result = openssl_decrypt(substr($raw, 16), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, substr($raw, 0, 16));
            return $result !== false ? $result : null;
        } catch (\Throwable) {
            return null;
        }
    }

    // ─── Derive per-subscriber module encryption key ─────────────────────────
    // Mirrors Child's DynamicLogicService::getEncryptionKey() exactly:
    // key = SHA256( child_app_key + child_app_url )

    public function encryptModule(string $code): string
    {
        $key = hash('sha256', $this->child_app_key . $this->domain, true);
        $iv  = random_bytes(16);
        $enc = openssl_encrypt($code, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $enc);
    }

    public function product()
    {
        return $this->belongsTo(LicensedProduct::class, 'licensed_product_id');
    }
}
