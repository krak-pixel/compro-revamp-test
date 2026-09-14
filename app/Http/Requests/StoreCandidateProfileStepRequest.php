<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCandidateProfileStepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return match ((int) $this->route('step')) {
            1 => [
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
                'full_name' => ['required', 'string', 'max:150'],
                'national_id' => ['required', 'digits:16'],
                'birth_date' => ['required', 'date', 'before:today'],
                'birth_place' => ['required', 'string', 'max:100'],
                'gender' => ['required', Rule::in(['male', 'female'])],
                'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
                'blood_type' => ['required', Rule::in(['A', 'B', 'AB', 'O'])],
                'religion' => ['required', Rule::in(['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu', 'lainnya'])],
            ],
            2 => [
                'height_cm' => ['required', 'integer', 'between:100,250'],
                'weight_kg' => ['required', 'integer', 'between:30,300'],
                'nationality' => ['required', 'string', 'max:80'],
                'residence_city' => ['required', 'string', 'max:120'],
                'identity_address' => ['required', 'string', 'max:1000'],
                'phone' => ['required', 'regex:/^(?=.*\d)[0-9+()\-\s]{8,30}$/'],
                'domicile_address' => ['required', 'string', 'max:1000'],
            ],
            3 => [
                'high_school.institution_name' => ['required', 'string', 'max:150'],
                'high_school.field_of_study' => ['required', 'string', 'max:120'],
                'high_school.start_year' => ['required', 'integer', 'between:1950,'.now()->year],
                'high_school.end_year' => ['required', 'integer', 'gte:high_school.start_year', 'max:'.now()->year],
                'high_school.final_score' => ['required', 'numeric', 'between:0,100'],
                'high_school.diploma' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
                'college_educations' => ['nullable', 'array', 'max:4'],
                'college_educations.*.id' => ['nullable', 'integer'],
                'college_educations.*.institution_name' => ['required', 'string', 'max:150'],
                'college_educations.*.degree' => ['required', Rule::in(['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])],
                'college_educations.*.field_of_study' => ['required', 'string', 'max:120'],
                'college_educations.*.start_year' => ['required', 'integer', 'between:1950,'.now()->year],
                'college_educations.*.end_year' => ['nullable', 'integer', 'gte:college_educations.*.start_year', 'max:'.now()->year],
                'college_educations.*.final_score' => ['nullable', 'numeric', 'between:0,4'],
                'college_educations.*.diploma' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            ],
            4 => [
                'experience_status' => ['required', Rule::in(['fresh_graduate', 'experienced'])],
                'work_experiences' => ['exclude_unless:experience_status,experienced', 'required', 'array', 'min:1', 'max:3'],
                'work_experiences.*.id' => ['nullable', 'integer'],
                'work_experiences.*.company_name' => ['required', 'string', 'max:150'],
                'work_experiences.*.initial_position' => ['required', 'string', 'max:120'],
                'work_experiences.*.initial_started_at' => ['required', 'date_format:Y-m'],
                'work_experiences.*.initial_ended_at' => ['required', 'date_format:Y-m', 'after_or_equal:work_experiences.*.initial_started_at'],
                'work_experiences.*.initial_responsibilities' => ['required', 'string', 'max:2000'],
                'work_experiences.*.final_position' => ['required', 'string', 'max:120'],
                'work_experiences.*.final_started_at' => ['required', 'date_format:Y-m', 'after_or_equal:work_experiences.*.initial_ended_at'],
                'work_experiences.*.final_ended_at' => ['nullable', 'date_format:Y-m', 'after_or_equal:work_experiences.*.final_started_at'],
                'work_experiences.*.final_responsibilities' => ['required', 'string', 'max:2000'],
                'work_experiences.*.is_current' => ['nullable', 'boolean'],
                'work_experiences.*.resign_year' => ['nullable', 'integer', 'between:1950,'.now()->year],
                'work_experiences.*.last_salary' => ['nullable', 'integer', 'min:0'],
                'work_experiences.*.resign_reason' => ['nullable', 'string', 'max:1000'],
                'work_experiences.*.expected_salary' => ['nullable', 'integer', 'min:0'],
                'work_experiences.*.company_phone' => ['nullable', 'regex:/^(?=.*\d)[0-9+()\-\s]{8,30}$/'],
                'work_experiences.*.supervisor_name' => ['nullable', 'string', 'max:150'],
                'work_experiences.*.supervisor_phone' => ['nullable', 'regex:/^(?=.*\d)[0-9+()\-\s]{8,30}$/'],
                'work_experiences.*.employment_letter' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            ],
            default => [],
        };
    }

    public function attributes(): array
    {
        return [
            'national_id' => 'nomor KTP',
            'photo' => 'foto profil',
            'cv' => 'CV',
            'high_school.diploma' => 'ijazah SMA/SMK',
            'work_experiences' => 'pengalaman kerja',
        ];
    }
}
