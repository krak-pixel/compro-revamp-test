<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateWorkExperience extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'initial_started_at' => 'date',
            'initial_ended_at' => 'date',
            'final_started_at' => 'date',
            'final_ended_at' => 'date',
            'is_current' => 'boolean',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class, 'candidate_profile_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(CandidateDocument::class);
    }
}
