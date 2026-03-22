<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'country',
        'city',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'url',
        'referrer',
        'is_unique',
    ];

    /**
     * Scopes for analytics
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeUniqueToday($query)
    {
        return $query->whereDate('created_at', today())->where('is_unique', true);
    }
}
