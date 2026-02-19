@extends('frontend.layouts.app')

@section('title', 'Home - Madhesh Films')

@section('content')

    <!-- Hero Banner (Featured Video) -->
    @if($featuredVideo)
        @include('frontend.components.hero-banner', ['video' => $featuredVideo])
    @else
        <!-- Fallback Hero -->
        <section class="hero-fallback bg-dark text-center d-flex align-items-center" style="height: 80vh;">
            <div class="container">
                <h1 class="display-3 fw-bold mb-4">Welcome to Madhesh Films</h1>
                <p class="lead text-muted mb-5">Discover thousands of movies, TV shows, reels, and live TV</p>
                <a href="{{ route('movies.index') }}" class="btn btn-danger btn-lg px-5 py-3 rounded-pill">
                    <i class="fas fa-film me-2"></i> Explore Movies
                </a>
            </div>
        </section>
    @endif

    <!-- Continue Watching (logged-in users only) -->
    @auth
        @if($continueWatching->isNotEmpty())
            @include('frontend.components.movie-row', [
                'title' => 'Continue Watching',
                'videos' => $continueWatching,
                'type' => 'continue'
            ])
        @endif
    @endauth

    <!-- Trending Movies -->
    @if($trendingMovies->isNotEmpty())
        @include('frontend.components.movie-row', [
            'title' => 'Trending Movies',
            'videos' => $trendingMovies
        ])
    @endif

    <!-- Popular TV Shows -->
    @if($popularShows->isNotEmpty())
        @include('frontend.components.movie-row', [
            'title' => 'Popular TV Shows',
            'shows' => $popularShows,
            'is_show' => true
        ])
    @endif

    <!-- Trending Reels (vertical scroll feed) -->
    @if($reels->isNotEmpty())
        <section class="py-5 bg-black">
            <div class="container">
                <h2 class="h3 fw-bold mb-4 px-3 px-md-4">Trending Reels</h2>
                
                <div class="reel-feed d-flex flex-column gap-4 mx-auto" 
                     style="max-width: 420px; max-height: 85vh; overflow-y: auto; scroll-snap-type: y mandatory; padding: 0 15px;">
                    @foreach($reels as $reel)
                        @include('frontend.components.reel-card', ['reel' => $reel])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('styles')
<style>
    .hero-fallback {
        background: linear-gradient(135deg, #141414, #1a1a1a);
    }
    .reel-feed::-webkit-scrollbar {
        display: none;
    }
    .reel-feed {
        scrollbar-width: none;
    }
</style>
@endpush