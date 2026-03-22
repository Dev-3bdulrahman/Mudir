<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'color', 'icon'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];
}
