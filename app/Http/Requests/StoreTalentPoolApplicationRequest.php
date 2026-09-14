<?php

namespace App\Http\Requests;

use App\Models\Position;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreTalentPoolApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', Rule::exists('departments', 'id')->where('is_active', true)],
            'position_id' => ['required', Rule::exists('positions', 'id')->where('is_active', true)],
            'location_id' => ['required', Rule::exists('locations', 'id')->where('is_active', true)],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            if ($this->filled(['department_id', 'position_id']) && ! Position::query()
                ->whereKey($this->integer('position_id'))
                ->where('department_id', $this->integer('department_id'))
                ->exists()) {
                $validator->errors()->add('position_id', 'Posisi tidak tersedia untuk departemen yang dipilih.');
            }
        }];
    }
}
