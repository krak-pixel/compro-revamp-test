<?php

namespace App\Http\Controllers;

use App\Models\CandidateDocument;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CandidateDocumentController extends Controller
{
    public function __invoke(CandidateDocument $document): StreamedResponse
    {
        Gate::authorize('view', $document);
        abort_unless(Storage::disk($document->disk)->exists($document->path), 404);

        $headers = ['X-Content-Type-Options' => 'nosniff', 'Cache-Control' => 'private, no-store'];

        if (str_starts_with($document->mime_type, 'image/')) {
            return Storage::disk($document->disk)->response($document->path, $document->original_name, $headers);
        }

        return Storage::disk($document->disk)->download($document->path, $document->original_name, $headers);
    }
}
