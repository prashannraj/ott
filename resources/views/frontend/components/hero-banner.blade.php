@props(['video'])

@if($video)
    <section class="position-relative overflow-hidden" style="height: 85vh; min-height: 600px;">
        <!-- Banner background -->
        <div class="position-absolute inset-0 bg-cover bg-center"
             style="background-image: url('{{ $video->banner_url }}');">
            <!-- Dark gradient overlay -->
            <div class="position-absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
        </div>

        <!-- Content overlay -->
        <div class="container h-100 position-relative d-flex align-items-end pb-5">
            <div class="text-white max-w-3xl pb-5">
                <h1 class="display-3 fw-black mb-3 text-shadow">{{ $video->title }}</h1>
                
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <span class="badge bg-danger fs-5 px-3 py-2">{{ $video->age_rating ?? '13+' }}</span>
                    <span class="fs-5">{{ $video->release_date?->year ?? date('Y') }}</span>
                    @if($video->duration_sec)
                        <span class="fs-5">{{ floor($video->duration_sec / 60) }} min</span>
                    @endif
                    @foreach($video->genres as $genre)
                        <span class="badge bg-secondary">{{ $genre->name }}</span>
                    @endforeach
                </div>

                <p class="lead mb-4 fw-light text-shadow" style="max-width: 85%;">
                    {{ Str::limit($video->description ?? 'No description available.', 180) }}
                </p>

                <div class="d-flex gap-3">
                    <a href="{{ route('watch', $video->slug) }}" class="btn btn-danger btn-lg px-5 py-3 rounded-pill shadow-lg">
                        <i class="fas fa-play me-2"></i> Play
                    </a>
                    <button class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                        <i class="fas fa-info-circle me-2"></i> More Info
                    </button>
                </div>
            </div>
        </div>
    </section>

    <style>
        .text-shadow {
            text-shadow: 0 4px 12px rgba(0,0,0,0.9);
        }
    </style>
@else
    <!-- Fallback when no featured video -->
    <section class="bg-dark text-center py-5" style="height: 60vh; display: flex; align-items: center;">
        <div class="container">
            <h2 class="display-4 fw-bold">Welcome to Madhesh Films</h2>
            <p class="lead text-muted">Discover movies, shows, reels and live TV</p>
        </div>
    </section>
@endif