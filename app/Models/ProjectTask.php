<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTask extends Model
{
  protected $fillable = [
    'project_id',
    'title',
    'description',
    'status',
    'sort_order',
  ];

  public function project(): BelongsTo
  {
    return $this->belongsTo(Project::class);
  }
}
