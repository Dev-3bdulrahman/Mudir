<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'color', 'image'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];
}
