<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Job;
use App\Models\Location;
use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(Request $request): View
    {
        return $this->renderCareerPage($request);
    }

    public function show(Request $request, string $slug): View
    {
        return $this->renderCareerPage($request, $this->findVisibleJob($slug), 'detail');
    }

    public function apply(Request $request, string $slug): View
    {
        return $this->renderCareerPage($request, $this->findVisibleJob($slug), 'apply');
    }

    public function sendCv(Request $request): View
    {
        return $this->renderCareerPage($request, null, 'send-cv');
    }

    private function findVisibleJob(string $slug): Job
    {
        return Job::query()
            ->publiclyVisible()
            ->with(['department', 'position', 'location'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    private function renderCareerPage(
        Request $request,
        ?Job $selectedJob = null,
        ?string $drawerMode = null,
    ): View {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = Job::query()
            ->publiclyVisible()
            ->with(['department', 'position', 'location'])
            ->when($filters['q'] ?? null, function (Builder $jobs, string $keyword): void {
                $jobs->where(function (Builder $search) use ($keyword): void {
                    $search
                        ->where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhere('qualifications', 'like', "%{$keyword}%");
                });
            })
            ->when($filters['department'] ?? null, function (Builder $jobs, string $slug): void {
                $jobs->whereHas('department', fn (Builder $department) => $department->where('slug', $slug));
            })
            ->when($filters['position'] ?? null, function (Builder $jobs, string $slug): void {
                $jobs->whereHas('position', fn (Builder $position) => $position->where('slug', $slug));
            })
            ->when($filters['location'] ?? null, function (Builder $jobs, string $slug): void {
                $jobs->whereHas('location', fn (Builder $location) => $location->where('slug', $slug));
            })
            ->orderByDesc('published_at')
            ->orderBy('title');

        $jobs = $query->paginate(6)->withQueryString();
        $activeJobs = Job::query()->publiclyVisible();
        $activeCityCount = (clone $activeJobs)
            ->with('location:id,name')
            ->get()
            ->pluck('location.name')
            ->filter()
            ->flatMap(fn (string $name) => preg_split('/\s*\/\s*/', $name) ?: [])
            ->map(fn (string $name) => str($name)->trim()->lower()->toString())
            ->filter()
            ->unique()
            ->count();
        $queryParams = Arr::only($filters, ['q', 'department', 'position', 'location', 'page']);

        return view('career.index', [
            'jobs' => $jobs,
            'departments' => Department::query()->where('is_active', true)->orderBy('name')->get(),
            'positions' => Position::query()
                ->where('is_active', true)
                ->when($filters['department'] ?? null, function (Builder $positions, string $slug): void {
                    $positions->whereHas('department', fn (Builder $department) => $department->where('slug', $slug));
                })
                ->orderBy('name')
                ->get(),
            'locations' => Location::query()->where('is_active', true)->orderBy('name')->get(),
            'filters' => $filters,
            'stats' => [
                'jobs' => (clone $activeJobs)->count(),
                'locations' => $activeCityCount,
                'departments' => (clone $activeJobs)->distinct()->count('department_id'),
            ],
            'selectedJob' => $selectedJob,
            'drawerMode' => $drawerMode,
            'listUrl' => route('career.index', array_filter($queryParams, fn ($value) => filled($value))),
        ]);
    }
}
