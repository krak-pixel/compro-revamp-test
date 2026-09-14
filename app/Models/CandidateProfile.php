<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateProfile extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'national_id', 'birth_date', 'birth_place', 'gender',
        'marital_status', 'blood_type', 'religion', 'height_cm', 'weight_kg',
        'nationality', 'residence_city', 'identity_address', 'domicile_address',
        'phone', 'experience_status', 'current_step', 'profile_completed_at',
    ];

    protected function casts(): array
    {
        return [
            'national_id' => 'encrypted',
            'birth_date' => 'date',
            'profile_completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(CandidateEducation::class)->orderBy('sort_order');
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(CandidateWorkExperience::class)->orderBy('sort_order');
    }

    public function getMaskedNationalIdAttribute(): string
    {
        $value = (string) $this->national_id;

        return strlen($value) === 16 ? substr($value, 0, 4).'••••••••'.substr($value, -4) : 'Belum dilengkapi';
    }
}
