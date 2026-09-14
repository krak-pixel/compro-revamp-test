<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateEducation extends Model
{
    protected $table = 'candidate_educations';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_current' => 'boolean', 'final_score' => 'decimal:2'];
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
