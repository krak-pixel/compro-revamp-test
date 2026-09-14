<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('full_name')->nullable();
            $table->text('national_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('marital_status', 30)->nullable();
            $table->string('blood_type', 3)->nullable();
            $table->string('religion', 30)->nullable();
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->unsignedSmallInteger('weight_kg')->nullable();
            $table->string('nationality', 80)->nullable();
            $table->string('residence_city')->nullable();
            $table->text('identity_address')->nullable();
            $table->text('domicile_address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('experience_status', 30)->nullable();
            $table->unsignedTinyInteger('current_step')->default(1);
            $table->timestamp('profile_completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('candidate_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 40);
            $table->string('disk', 40)->default('local');
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size_bytes');
            $table->string('checksum', 64);
            $table->string('scan_status', 20)->default('pending_scan');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['user_id', 'type', 'is_active'], 'candidate_document_active_index');
        });

        Schema::create('candidate_educations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('candidate_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('document_id')->nullable()->constrained('candidate_documents')->nullOnDelete();
            $table->string('level', 30);
            $table->string('institution_name');
            $table->string('field_of_study');
            $table->unsignedSmallInteger('start_year');
            $table->unsignedSmallInteger('end_year')->nullable();
            $table->decimal('final_score', 5, 2)->nullable();
            $table->boolean('is_current')->default(false);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('candidate_work_experiences', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('candidate_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('document_id')->nullable()->constrained('candidate_documents')->nullOnDelete();
            $table->string('company_name');
            $table->string('initial_position');
            $table->date('initial_started_at');
            $table->date('initial_ended_at');
            $table->text('initial_responsibilities');
            $table->string('final_position');
            $table->date('final_started_at');
            $table->date('final_ended_at')->nullable();
            $table->text('final_responsibilities');
            $table->boolean('is_current')->default(false);
            $table->unsignedSmallInteger('resign_year')->nullable();
            $table->unsignedBigInteger('last_salary')->nullable();
            $table->text('resign_reason')->nullable();
            $table->unsignedBigInteger('expected_salary')->nullable();
            $table->string('company_phone', 30)->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_phone', 30)->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('applications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('position_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 30);
            $table->string('status', 30)->default('pending');
            $table->string('deduplication_key', 64)->unique();
            $table->json('candidate_snapshot');
            $table->json('job_snapshot')->nullable();
            $table->json('document_snapshot');
            $table->timestamp('submitted_at');
            $table->timestamps();

            $table->index(['user_id', 'submitted_at']);
            $table->index(['status', 'submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
        Schema::dropIfExists('candidate_work_experiences');
        Schema::dropIfExists('candidate_educations');
        Schema::dropIfExists('candidate_documents');
        Schema::dropIfExists('candidate_profiles');
    }
};
