<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
  protected $fillable = [
    'invoice_number',
    'amount',
    'currency',
    'status',
    'due_date',
    'paid_date',
    'notes',
  ];

  protected function casts(): array
  {
    return [
      'due_date' => 'date',
      'paid_date' => 'date',
      'amount' => 'decimal:2',
    ];
  }

  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }

  public function project(): BelongsTo
  {
    return $this->belongsTo(Project::class);
  }
}
