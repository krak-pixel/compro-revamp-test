<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('position_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('location_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('employment_type', 30)->default('full_time');
            $table->text('description');
            $table->json('qualifications');
            $table->string('poster_path');
            $table->date('opens_at');
            $table->date('closes_at');
            $table->string('status', 30)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'opens_at', 'closes_at']);
            $table->index(['department_id', 'position_id', 'location_id'], 'jobs_filter_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
