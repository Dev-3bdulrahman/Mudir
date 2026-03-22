<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
  use HasTranslations;

  protected $fillable = [
    'client_id',
    'contract_template_id',
    'contract_number',
    'title',
    'content',
    'status',
    'signed_at',
    'expires_at',
    'total_amount',
    'currency'
  ];

  protected $casts = [
    'title' => 'array',
    'content' => 'array',
    'signed_at' => 'datetime',
    'expires_at' => 'date',
    'total_amount' => 'decimal:2',
  ];

  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }

  public function template(): BelongsTo
  {
    return $this->belongsTo(ContractTemplate::class, 'contract_template_id');
  }
}
