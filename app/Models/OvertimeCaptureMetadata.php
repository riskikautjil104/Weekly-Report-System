<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OvertimeCaptureMetadata extends Model
{
    protected $table = 'overtime_capture_metadata';

    protected $fillable = [
        'overtime_request_id',
        'image_hash',
        'image_width',
        'image_height',
        'file_size_bytes',
        'camera_facing',
        'geo_latitude',
        'geo_longitude',
        'geo_accuracy',
        'device_user_agent',
        'ip_address',
        'captured_at',
    ];

    protected function casts(): array
    {
        return [
            'captured_at' => 'datetime',
        ];
    }

    public function overtimeRequest(): BelongsTo
    {
        return $this->belongsTo(OvertimeRequest::class);
    }

    public function hasLocation(): bool
    {
        return $this->geo_latitude !== null && $this->geo_longitude !== null;
    }

    public function mapsUrl(): ?string
    {
        if (! $this->hasLocation()) {
            return null;
        }

        return sprintf(
            'https://www.google.com/maps?q=%s,%s',
            $this->geo_latitude,
            $this->geo_longitude
        );
    }

    public function formattedLocation(): string
    {
        if (! $this->hasLocation()) {
            return '—';
        }

        $coords = number_format((float) $this->geo_latitude, 6) . ', ' . number_format((float) $this->geo_longitude, 6);

        if ($this->geo_accuracy !== null) {
            return $coords . ' (±' . round((float) $this->geo_accuracy) . 'm)';
        }

        return $coords;
    }
}
