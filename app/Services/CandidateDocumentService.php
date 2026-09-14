<?php

namespace App\Services;

use App\Models\CandidateDocument;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CandidateDocumentService
{
    public function store(User $user, UploadedFile $file, string $type): CandidateDocument
    {
        $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension());
        $filename = Str::uuid().($extension ? '.'.$extension : '');
        $path = $file->storeAs("candidates/{$user->id}/{$type}", $filename, 'local');
        throw_if(! $path, \RuntimeException::class, 'Dokumen tidak dapat disimpan.');

        return DB::transaction(function () use ($user, $file, $type, $path): CandidateDocument {
            if (in_array($type, ['photo', 'cv', 'high_school_diploma'], true)) {
                CandidateDocument::query()
                    ->where('user_id', $user->id)
                    ->where('type', $type)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }

            return CandidateDocument::create([
                'user_id' => $user->id,
                'type' => $type,
                'disk' => 'local',
                'path' => $path,
                'original_name' => Str::of($file->getClientOriginalName())->replace('\\', '/')->afterLast('/')->limit(200)->toString(),
                'mime_type' => (string) $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'checksum' => hash_file('sha256', $file->getRealPath()),
                'scan_status' => 'pending_scan',
                'is_active' => true,
            ]);
        });
    }
}
