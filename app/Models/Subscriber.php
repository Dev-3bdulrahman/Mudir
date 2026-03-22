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
        'status', 
        'expires_at', 
        'grace_period_days'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'grace_period_days' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(LicensedProduct::class, 'licensed_product_id');
    }
}
