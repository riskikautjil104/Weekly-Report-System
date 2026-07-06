<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_start',
        'day',
        'tanggal',
        'waktu',
        'title',
        'description',
        'waha_chat_id',
        'sent_to_whatsapp',
        'reminder_sent',
        'reminder_sent_at',
        'waha_sent_at',
        'waha_send_error',
    ];

    protected $casts = [
        'week_start' => 'date',
        'tanggal' => 'date',
        'waktu' => 'string',
        'sent_to_whatsapp' => 'boolean',
        'reminder_sent' => 'boolean',
        'reminder_sent_at' => 'datetime',
        'waha_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
