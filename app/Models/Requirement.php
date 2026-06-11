<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'status',
        'body',
        'impact_analysis',
        'business_rules',

        // Informasi request
        'request_number',
        'request_date',
        'department',
        'requester_title',
        'contact_number',

        // Alur & detail
        'current_workflow',
        'expected_workflow',
        'business_goal',
        'expected_benefits',
        'affected_menu',
        'field_changes',

        // Risiko, prioritas, rules
        'potential_risk',
        'priority',
        'priority_reason',
        'validation_rules',
        'uiux_notes',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(RequirementComment::class, 'requirement_id')->orderByDesc('created_at');
    }
}