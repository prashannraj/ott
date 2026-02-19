@props(['video'])

<div class="card bg-dark border-0 shadow-sm overflow-hidden transition-all hover:scale-105" 
     style="min-width: 200px; max-width: 200px;">
    <a href="{{ route('videos.show', $video->slug) }}" class="text-decoration-none text-white">
        <img src="{{ $video->poster_url }}" 
             class="card-img-top w-100 object-fit-cover" 
             alt="{{ $video->title }}"
             style="aspect-ratio: 2/3;">
    </a>
    <div class="card-body p-3">
        <h6 class="card-title mb-1 fw-semibold text-truncate">{{ $video->title }}</h6>
        <small class="text-muted d-block">
            {{ $video->release_date?->year ?? '—' }} • {{ $video->age_rating ?? '—' }}
        </small>
    </div>
</div>

<style>
    .card:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
</style>