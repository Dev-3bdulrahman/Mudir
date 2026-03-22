<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectType extends Model
{
  use HasTranslations;

  protected $fillable = ['name', 'slug', 'color', 'icon', 'is_active'];

  protected $casts = [
    'name' => 'array',
    'is_active' => 'boolean',
  ];

  public function projects(): HasMany
  {
    return $this->hasMany(Project::class);
  }
}
