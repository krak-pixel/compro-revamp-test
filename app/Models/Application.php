<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'candidate_snapshot' => 'array',
            'job_snapshot' => 'array',
            'document_snapshot' => 'array',
            'submitted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'review' => 'Sedang Ditinjau',
            'shortlisted' => 'Lolos Seleksi',
            'rejected' => 'Belum Sesuai',
            default => 'Menunggu',
        };
    }
}
