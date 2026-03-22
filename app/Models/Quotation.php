<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_name',
        'client_email',
        'client_phone',
        'amount',
        'currency',
        'items',
        'status',
        'language',
        'notes',
        'expired_at',
    ];

    protected $casts = [
        'items' => 'array',
        'expired_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getDisplayNameAttribute()
    {
        return $this->client ? $this->client->user->name : $this->client_name;
    }
}
