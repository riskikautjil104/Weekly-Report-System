<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlySheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'title',
        'sheet_url',
        'sheet_gid',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'month' => 'date',
            'is_active' => 'boolean',
        ];
    }
}
