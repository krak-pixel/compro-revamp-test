<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    protected $fillable = [
        'department_id',
        'position_id',
        'location_id',
        'title',
        'slug',
        'employment_type',
        'description',
        'qualifications',
        'poster_path',
        'opens_at',
        'closes_at',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'qualifications' => 'array',
            'opens_at' => 'date',
            'closes_at' => 'date',
            'published_at' => 'datetime',
        ];
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

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->whereDate('opens_at', '<=', today())
            ->whereDate('closes_at', '>=', today())
            ->where(function (Builder $published): void {
                $published
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function getEmploymentTypeLabelAttribute(): string
    {
        return match ($this->employment_type) {
            'part_time' => 'Part-time',
            'contract' => 'Kontrak',
            'internship' => 'Magang',
            default => 'Full-time',
        };
    }
}
