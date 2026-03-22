<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
  protected $fillable = [
    'client_id',
    'project_id',
    'assigned_to',
    'subject',
    'status',
    'priority',
  ];

  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }

  public function project(): BelongsTo
  {
    return $this->belongsTo(Project::class);
  }

  public function assignedEmployee(): BelongsTo
  {
    return $this->belongsTo(User::class, 'assigned_to');
  }

  public function messages(): HasMany
  {
    return $this->hasMany(TicketMessage::class)->orderBy('created_at');
  }

  /**
   * Get priority color for UI.
   */
  public function getPriorityColorAttribute(): string
  {
    return match ($this->priority) {
      'low' => '#10b981',
      'normal' => '#3b82f6',
      'high' => '#f59e0b',
      'urgent' => '#ef4444',
      default => '#6b7280',
    };
  }

  /**
   * Get status color for UI.
   */
  public function getStatusColorAttribute(): string
  {
    return match ($this->status) {
      'open' => '#3b82f6',
      'in_progress' => '#f59e0b',
      'resolved' => '#10b981',
      'closed' => '#6b7280',
      default => '#6b7280',
    };
  }
}
