<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class LicensedProduct extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'description', 'dashboard_code', 'modules'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'modules' => 'array',
    ];

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}
