<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
  protected $fillable = [
    'user_id',
    'assigned_by',
    'title',
    'description',
    'status',
    'priority',
    'due_date',
  ];

  protected function casts(): array
  {
    return [
      'due_date' => 'date',
    ];
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function assigner(): BelongsTo
  {
    return $this->belongsTo(User::class, 'assigned_by');
  }

  public function getPriorityColorAttribute(): string
  {
    return match ($this->priority) {
      'low' => '#10b981',
      'normal' => '#3b82f6',
      'high' => '#ef4444',
      default => '#6b7280',
    };
  }
}
