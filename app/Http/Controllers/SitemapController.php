<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $jobs = Job::query()
            ->publiclyVisible()
            ->orderByDesc('updated_at')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', ['jobs' => $jobs])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
