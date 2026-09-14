<?php

namespace App\Policies;

use App\Models\CandidateDocument;
use App\Models\User;

class CandidateDocumentPolicy
{
    public function view(User $user, CandidateDocument $document): bool
    {
        return $document->user_id === $user->id;
    }
}
