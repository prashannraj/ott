@props(['reel'])

<div class="card bg-dark border-0 shadow rounded overflow-hidden" style="aspect-ratio: 9/16; max-width: 380px;">
    <a href="{{ route('reels.show', $reel->slug) }}">
        <img src="{{ $reel->poster_path ? Storage::url($reel->poster_path) : asset('images/reel-placeholder.jpg') }}" 
             class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $reel->title }}">
        
        <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-to-t from-black to-transparent">
            <h6 class="mb-1 text-truncate">{{ $reel->title }}</h6>
            <small class="text-white-75">
                <i class="far fa-heart me-1"></i> {{ $reel->likes_count ?? 0 }}
            </small>
        </div>
    </a>
</div>