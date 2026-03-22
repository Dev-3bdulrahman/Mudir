<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
  protected $fillable = [
    'client_id',
    'project_type_id', // Add this
    'name',
    'type', // Keep for now for compatibility during migration
    'status',
    'description',
    'preview_url',
    'color',
  ];

  public function projectType(): BelongsTo
  {
    return $this->belongsTo(ProjectType::class);
  }

  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }

  public function tasks(): HasMany
  {
    return $this->hasMany(ProjectTask::class)->orderBy('sort_order');
  }

  public function updates(): HasMany
  {
    return $this->hasMany(ProjectUpdate::class)->orderByDesc('created_at');
  }

  public function invoices(): HasMany
  {
    return $this->hasMany(Invoice::class);
  }

  public function tickets(): HasMany
  {
    return $this->hasMany(Ticket::class);
  }

  public function employees(): BelongsToMany
  {
    return $this->belongsToMany(User::class, 'project_employee')->withTimestamps();
  }

  /**
   * Calculate progress based on completed tasks.
   */
  public function getProgressAttribute(): int
  {
    $total = $this->tasks()->count();
    if ($total === 0) {
      return 0;
    }
    $done = $this->tasks()->where('status', 'done')->count();
    return (int) round(($done / $total) * 100);
  }
}
