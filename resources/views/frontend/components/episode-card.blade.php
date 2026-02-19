@props([
    'episode',
    'show' => null,           // optional - parent show
])

<a href="{{ route('episodes.watch', $episode->id) }}" class="text-decoration-none text-white">
    <div class="episode-card rounded overflow-hidden shadow-sm transition-all hover:shadow-xl hover:scale-[1.03] bg-gray-900">
        <div class="position-relative">
            <img src="{{ $episode->thumbnail_url ?? $show?->poster_url ?? asset('images/episode-placeholder.jpg') }}"
                 alt="{{ $episode->title }}"
                 class="w-100 object-fit-cover ratio ratio-16x9">

            <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-to-t from-black to-transparent">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <h6 class="mb-1 fw-semibold">{{ $episode->episode_number ? "S{$episode->season_number} E{$episode->episode_number}" : $episode->title }}</h6>
                        <small class="text-white-50">{{ $episode->title }}</small>
                    </div>
                    <small class="badge bg-dark opacity-75">{{ $episode->duration ?? '—' }}</small>
                </div>
            </div>

            @if($episode->is_new ?? false)
                <span class="position-absolute top-0 end-0 badge bg-danger m-2">New</span>
            @endif
        </div>
    </div>
</a>

<style>
    .episode-card:hover img {
        filter: brightness(0.85);
    }
</style>