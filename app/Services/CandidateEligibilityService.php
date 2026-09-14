<?php

namespace App\Services;

use App\Models\CandidateProfile;
use App\Models\User;

class CandidateEligibilityService
{
    public function isComplete(User $user): bool
    {
        return $this->missingRequirements($user) === [];
    }

    public function missingRequirements(User $user): array
    {
        $profile = $user->candidateProfile()
            ->with(['educations.document', 'workExperiences.document'])
            ->first();

        if (! $profile) {
            return ['Profil kandidat belum dibuat.'];
        }

        $missing = [];
        $required = [
            'full_name' => 'Nama lengkap',
            'national_id' => 'Nomor KTP',
            'birth_date' => 'Tanggal lahir',
            'birth_place' => 'Tempat lahir',
            'gender' => 'Jenis kelamin',
            'marital_status' => 'Status pernikahan',
            'blood_type' => 'Golongan darah',
            'religion' => 'Agama',
            'height_cm' => 'Tinggi badan',
            'weight_kg' => 'Berat badan',
            'nationality' => 'Kewarganegaraan',
            'residence_city' => 'Kota tempat tinggal',
            'identity_address' => 'Alamat KTP',
            'domicile_address' => 'Alamat domisili',
            'phone' => 'Nomor telepon',
            'experience_status' => 'Status pengalaman',
        ];

        foreach ($required as $field => $label) {
            if (blank($profile->{$field})) {
                $missing[] = $label;
            }
        }

        foreach (['photo' => 'Foto profil', 'cv' => 'CV'] as $type => $label) {
            if (! $user->activeDocument($type)) {
                $missing[] = $label;
            }
        }

        $highSchool = $profile->educations->firstWhere('level', 'high_school');
        if (! $highSchool || ! $highSchool->document) {
            $missing[] = 'Data dan ijazah SMA/SMK';
        }

        if ($profile->experience_status === 'experienced' && $profile->workExperiences->isEmpty()) {
            $missing[] = 'Minimal satu pengalaman kerja';
        }

        return $missing;
    }
}
