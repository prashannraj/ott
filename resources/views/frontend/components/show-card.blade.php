@props(['show'])

<div class="card bg-dark border-0 shadow-sm" style="min-width: 200px; max-width: 200px;">
    <a href="{{ route('shows.show', $show->slug) }}">
        <img src="{{ $show->poster_path ? Storage::url($show->poster_path) : asset('images/placeholder-poster.jpg') }}" 
             class="card-img-top" alt="{{ $show->title }}">
    </a>
    <div class="card-body p-2">
        <h6 class="card-title mb-1 text-truncate">{{ $show->title }}</h6>
        <small class="text-muted">
            {{ $show->seasons_count ?? '—' }} Seasons
        </small>
    </div>
</div>