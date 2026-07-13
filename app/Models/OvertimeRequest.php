<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OvertimeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'durasi_menit',
        'alasan',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function captureMetadata(): HasOne
    {
        return $this->hasOne(OvertimeCaptureMetadata::class);
    }

    public function formattedDuration(): string
    {
        $hours = intdiv($this->durasi_menit, 60);
        $minutes = $this->durasi_menit % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours} jam {$minutes} menit";
        }

        if ($hours > 0) {
            return "{$hours} jam";
        }

        return "{$minutes} menit";
    }
}
