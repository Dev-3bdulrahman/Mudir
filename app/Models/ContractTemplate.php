<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractTemplate extends Model
{
  use HasTranslations;

  protected $fillable = ['title', 'content', 'is_active'];

  protected $casts = [
    'title' => 'array',
    'content' => 'array', // Will store localized clause arrays or blocks
    'is_active' => 'boolean',
  ];

  public function contracts(): HasMany
  {
    return $this->hasMany(Contract::class);
  }
}
