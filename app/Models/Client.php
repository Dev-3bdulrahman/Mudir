<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
  protected $fillable = [
    'user_id',
    'company_name',
    'phone',
    'avatar',
    'notes',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function projects(): HasMany
  {
    return $this->hasMany(Project::class);
  }

  public function invoices(): HasMany
  {
    return $this->hasMany(Invoice::class);
  }

  public function tickets(): HasMany
  {
    return $this->hasMany(Ticket::class);
  }
}
