@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')

@include('frontend.components.hero-banner', ['movie' => $heroMovie])

<div class="mt-8">
    <h2 class="text-xl font-bold mb-2">Trending Movies</h2>
    @include('frontend.components.movie-row', ['movies' => $trendingMovies])
</div>

<div class="mt-8">
    <h2 class="text-xl font-bold mb-2">Latest Movies</h2>
    @include('frontend.components.movie-row', ['movies' => $latestMovies])
</div>

<div class="mt-8">
    <h2 class="text-xl font-bold mb-2">Reels / Live Preview</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($reels as $reel)
            @include('frontend.components.reel-card', ['reel' => $reel])
        @endforeach
    </div>
</div>

<div class="mt-8">
    @include('frontend.components.pagination', ['paginator' => $latestMovies])
</div>

@endsection
