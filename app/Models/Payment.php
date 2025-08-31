<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'company_id',
        'user_id',
        'provider',
        'amount',
        'currency',
        'ccy',
        'status',
        'payload',
        'order',
        'payable_type',
        'payable_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payload' => 'array',
        'order' => 'array',
    ];

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function activity(): HasOne
    {
        return $this->hasOne(Activity::class, 'id', 'payable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
