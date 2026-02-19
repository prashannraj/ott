@extends('frontend.layouts.app')

@section('title', $video->title . ' - OTT Stream')

@section('content')
    <div class="container py-5">
        <div class="row g-5">
            <!-- Poster + Actions -->
            <div class="col-lg-4">
                <div class="ratio ratio-2x3 rounded overflow-hidden shadow-lg mb-4">
                    <img src="{{ $video->poster_path ? Storage::url($video->poster_path) : asset('images/placeholder-poster.jpg') }}" 
                         alt="{{ $video->title }}" 
                         class="object-fit-cover">
                </div>

                <div class="d-grid gap-3">
                    <a href="{{ route('watch', $video->slug) }}" class="btn btn-danger btn-lg">
                        <i class="fas fa-play me-2"></i> Watch Now
                    </a>

                    <!-- Watchlist button (यदि तपाईंसँग छ भने) -->
                    @include('frontend.components.watchlist-button', ['item' => $video, 'type' => 'video'])
                </div>

                <!-- Trailer (यदि video मा trailer छ भने) -->
                @if($video->trailer_url ?? false)
                    <div class="mt-4">
                        <h6>Trailer</h6>
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $video->trailer_url }}" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Details Section -->
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">{{ $video->title }}</h1>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    @if($video->age_rating)
                        <span class="badge bg-danger fs-5 px-3 py-2">{{ $video->age_rating }}</span>
                    @endif
                    <span class="fs-5">{{ $video->release_date?->year ?? date('Y') }}</span>
                    @if($video->duration_sec)
                        <span class="fs-5">{{ floor($video->duration_sec / 60) }} min</span>
                    @endif
                    @foreach($video->genres as $genre)
                        <span class="badge bg-secondary">{{ $genre->name }}</span>
                    @endforeach
                </div>

                <p class="lead mb-4">{{ $video->description ?? 'No description available.' }}</p>

                <!-- If it's an episode -->
                @if($video->episode)
                    <p class="text-muted fw-semibold">
                        {{ $video->episode->season->tvShow->title ?? 'TV Show' }} 
                        • Season {{ $video->episode->season->season_number ?? '?' }} 
                        • Episode {{ $video->episode->episode_number ?? '?' }}
                    </p>
                @endif

                <!-- Related Videos -->
                @if($related->isNotEmpty())
                    <h4 class="mt-5 mb-3">More like this</h4>
                    <div class="d-flex overflow-auto gap-3 pb-3">
                        @foreach($related as $relVideo)
                            @include('frontend.components.movie-card', ['video' => $relVideo])
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection