@props(['filters', 'departments', 'positions', 'locations'])

<form x-ref="filterForm" action="{{ route('career.index') }}" method="GET" class="grid gap-4 rounded-tvip-card border border-tvip-divider bg-white p-6 shadow-tvip-job lg:grid-cols-[minmax(260px,1.8fr)_repeat(3,minmax(170px,1fr))] lg:px-6 lg:py-8" role="search">
    <div class="relative">
        <label for="career-search" class="sr-only">Cari posisi atau kualifikasi</label>
        <img src="{{ asset('images/tvip/career/icon-search.svg') }}" alt="" aria-hidden="true" class="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2">
        <input
            x-ref="searchInput"
            x-model="searchQuery"
            id="career-search"
            name="q"
            type="search"
            value="{{ $filters['q'] ?? '' }}"
            placeholder="Cari posisi, kualifikasi..."
            class="career-control pl-11 pr-11"
        >
        <button x-cloak x-show="searchQuery.length" type="button" @click="clearSearch()" class="absolute right-1 top-1/2 inline-flex size-10 -translate-y-1/2 items-center justify-center rounded-md text-lg text-tvip-muted hover:bg-tvip-surface" aria-label="Hapus pencarian">×</button>
    </div>

    <div class="relative">
        <label for="career-department" class="sr-only">Departemen</label>
        <img src="{{ asset('images/tvip/career/icon-department.svg') }}" alt="" aria-hidden="true" class="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2">
        <select id="career-department" name="department" class="career-control pl-11" @change="$refs.filterForm.requestSubmit()">
            <option value="">Semua Departemen</option>
            @foreach ($departments as $department)
                <option value="{{ $department->slug }}" @selected(($filters['department'] ?? '') === $department->slug)>{{ $department->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="relative">
        <label for="career-position" class="sr-only">Posisi</label>
        <img src="{{ asset('images/tvip/career/icon-position.svg') }}" alt="" aria-hidden="true" class="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2">
        <select id="career-position" name="position" class="career-control pl-11" @change="$refs.filterForm.requestSubmit()">
            <option value="">Semua Posisi</option>
            @foreach ($positions as $position)
                <option value="{{ $position->slug }}" @selected(($filters['position'] ?? '') === $position->slug)>{{ $position->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="relative">
        <label for="career-location" class="sr-only">Lokasi</label>
        <img src="{{ asset('images/tvip/career/icon-location.svg') }}" alt="" aria-hidden="true" class="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2">
        <select id="career-location" name="location" class="career-control pl-11" @change="$refs.filterForm.requestSubmit()">
            <option value="">Semua Lokasi</option>
            @foreach ($locations as $location)
                <option value="{{ $location->slug }}" @selected(($filters['location'] ?? '') === $location->slug)>{{ $location->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="sr-only">Terapkan pencarian</button>
</form>
