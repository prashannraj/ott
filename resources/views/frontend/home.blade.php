@extends('frontend.layouts.app')

@section('content')

    <!-- Hero / Featured -->
    @if($featuredVideo)
        @include('frontend.components.hero-banner', ['video' => $featuredVideo])
    @endif

    <!-- Continue Watching (only for logged-in users) -->
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
            'isShow' => true
        ])

    @endif

    <!-- Latest Reels (vertical scroll feed) -->
    @if($reels->isNotEmpty())
        <section class="py-5 bg-dark">
            <div class="container">
                <h2 class="fs-3 fw-bold mb-4 px-3">Trending Reels</h2>
                <div class="reel-feed d-flex flex-column gap-4 mx-auto" 
                     style="max-width: 420px; max-height: 85vh; overflow-y: auto; scroll-snap-type: y mandatory;">
                    @foreach($reels as $reelVideo)
                        <div class="snap-center">
                            @include('frontend.components.reel-card', ['reel' => $reelVideo])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Optional: more rows like New Releases, Top Genres etc. -->

@endsection