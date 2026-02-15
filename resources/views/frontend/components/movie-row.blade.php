<div class="flex overflow-x-auto space-x-4">
    @foreach($movies as $movie)
        @include('frontend.components.movie-card', ['movie' => $movie])
    @endforeach
</div>
