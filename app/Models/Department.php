<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['name', 'slug', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
