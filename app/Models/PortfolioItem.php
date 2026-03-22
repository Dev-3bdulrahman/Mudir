<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class PortfolioItem extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'year', 'color', 'image'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];
}
