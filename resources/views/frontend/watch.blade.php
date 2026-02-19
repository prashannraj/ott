@extends('frontend.layouts.app')

@section('title', 'Watching - ' . $video->title)

@section('content')
    <div class="container-fluid p-0 bg-black">
        <!-- Video Player Section -->
        <div class="row g-0">
            <div class="col-12">
                <div class="video-player-wrapper position-relative" style="max-height: 90vh;">
                    <video id="ottPlayer" 
                           class="w-100 h-auto" 
                           style="background: #000;"
                           controls 
                           playsinline 
                           {{ $autoplay ?? false ? 'autoplay muted' : '' }}>
                        
                        <!-- HLS Primary Source -->
                        @php
                            $hlsFile = $video->files->where('format', 'hls')->first();
                            $mp4File = $video->files->where('format', 'mp4')->first();
                        @endphp

                        @if($hlsFile)
                            <source src="{{ Storage::url($hlsFile->path) }}" type="application/x-mpegURL">
                        @endif

                        <!-- MP4 Fallback -->
                        @if($mp4File)
                            <source src="{{ Storage::url($mp4File->path) }}" type="video/mp4">
                        @endif

                        <!-- Subtitles -->
                        @foreach($video->subtitles ?? [] as $subtitle)
                            <track kind="subtitles"
                                   src="{{ Storage::url($subtitle->file_path) }}"
                                   srclang="{{ $subtitle->language_code }}"
                                   label="{{ $subtitle->label }}"
                                   {{ $subtitle->language_code === app()->getLocale() ? 'default' : '' }}>
                        @endforeach

                        <p class="text-white text-center p-5">
                            Your browser does not support video playback. Please update your browser.
                        </p>
                    </video>

                    <!-- Floating Back & Title -->
                    <div class="position-absolute top-0 start-0 end-0 p-3 bg-gradient-to-b from-black/80 to-transparent text-white pointer-events-none z-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ url()->previous() ?? route('home') }}" class="btn btn-dark btn-sm rounded-pill pointer-events-auto">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <h5 class="mb-0 pointer-events-auto text-truncate ms-3">{{ $video->title }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Info (below player) -->
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3">{{ $video->title }}</h2>
                    
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        @if($video->age_rating)
                            <span class="badge bg-danger px-3 py-2">{{ $video->age_rating }}</span>
                        @endif
                        <span>{{ $video->release_date?->year ?? date('Y') }}</span>
                        @if($video->duration_sec)
                            <span>{{ floor($video->duration_sec / 60) }} min</span>
                        @endif
                        @foreach($video->genres as $genre)
                            <span class="badge bg-secondary">{{ $genre->name }}</span>
                        @endforeach
                    </div>

                    <p class="lead text-muted">{{ $video->description ?? 'No description available.' }}</p>

                    <!-- Episode Info if applicable -->
                    @if($video->episode)
                        <p class="text-muted fw-semibold">
                            {{ $video->episode->season->tvShow->title ?? 'TV Show' }} 
                            • Season {{ $video->episode->season->season_number ?? '?' }} 
                            • Episode {{ $video->episode->episode_number ?? '?' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('ottPlayer');
    if (!video) return;

    const hlsSource = video.querySelector('source[type="application/x-mpegURL"]')?.src;

    if (Hls.isSupported() && hlsSource) {
        const hls = new Hls({
            debug: false,
            enableWorker: true,
            lowLatencyMode: true,
            backBufferLength: 90,
            maxBufferLength: 60,
        });

        hls.loadSource(hlsSource);
        hls.attachMedia(video);

        hls.on(Hls.Events.MANIFEST_PARSED, function () {
            console.log('HLS manifest loaded');
            video.play().catch(e => console.warn('Autoplay blocked:', e));
        });

        hls.on(Hls.Events.ERROR, function (event, data) {
            console.error('HLS Error:', data);
            if (data.fatal) {
                if (data.type === Hls.ErrorTypes.NETWORK_ERROR) {
                    hls.startLoad();
                } else if (data.type === Hls.ErrorTypes.MEDIA_ERROR) {
                    hls.recoverMediaError();
                } else {
                    hls.destroy();
                }
            }
        });
    } 
    // Native HLS support (Safari, iOS)
    else if (video.canPlayType('application/vnd.apple.mpegurl') && hlsSource) {
        video.src = hlsSource;
        console.log('Using native HLS');
        video.play().catch(e => console.warn('Autoplay blocked:', e));
    } else {
        console.warn('HLS not supported in this browser');
    }

    // Progress saving (every 10s)
    video.addEventListener('timeupdate', function () {
        const current = Math.floor(video.currentTime);
        if (current > 0 && current % 10 === 0) {
            fetch('{{ route("api.watch.progress") ?? "/api/watch-progress" }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    video_id: {{ $video->id }},
                    position_sec: current,
                    duration_sec: Math.floor(video.duration) || 0
                })
            }).catch(err => console.error('Progress save failed:', err));
        }
    });
});
</script>
@endpush