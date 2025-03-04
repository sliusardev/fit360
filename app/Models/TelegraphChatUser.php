<?php

namespace App\Models;

use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegraphChatUser extends Model
{
    protected $fillable = [
        'telegraph_chat_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function telegraphChat(): BelongsTo
    {
        return $this->belongsTo(TelegraphChat::class);
    }
}
