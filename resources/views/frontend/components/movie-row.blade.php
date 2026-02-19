@props([
    'title' => 'Row Title',
    'videos' => collect(),
    'shows' => collect(),
    'is_show' => false,
    'type' => ''
])

<section class="py-4 bg-black">
    <h2 class="h4 fw-bold mb-3 px-4 px-md-5">{{ $title }}</h2>

    <div class="d-flex overflow-auto gap-3 px-4 px-md-5 pb-4" style="scrollbar-width: none;">
        @if($is_show && $shows->isNotEmpty())
            @foreach($shows as $show)
                @include('frontend.components.show-card', ['show' => $show])
            @endforeach
        @elseif($videos->isNotEmpty())
            @foreach($videos as $video)
                @include('frontend.components.movie-card', ['video' => $video])
            @endforeach
        @endif
    </div>
</section>