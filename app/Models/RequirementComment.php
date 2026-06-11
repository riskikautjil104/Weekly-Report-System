<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequirementComment extends Model
{
    protected $fillable = [
        'requirement_id',
        'user_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }
}
