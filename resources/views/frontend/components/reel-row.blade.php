@props(['title', 'reels' => collect()])

<section class="py-5 bg-black">
    <div class="container">
        <h2 class="h4 fw-bold mb-4 px-3 px-md-4">{{ $title }}</h2>
        
        <div class="reel-feed d-flex flex-column gap-4 mx-auto" 
             style="max-width: 420px; max-height: 85vh; overflow-y: auto; scroll-snap-type: y mandatory;">
            @foreach($reels as $reel)
                @include('frontend.components.reel-card', ['reel' => $reel])
            @endforeach
        </div>
    </div>
</section>