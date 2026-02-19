<!-- resources/views/frontend/components/video-player.blade.php -->
@props([
    'video',                // Required: Video model instance
    'title' => 'Playing...',
    'autoplay' => false,
    'controls' => true,
    'poster' => null,
])

<div class="video-player-wrapper position-relative bg-black rounded overflow-hidden shadow-lg">
    <video id="ottPlayer" 
           class="w-100" 
           style="max-height: 85vh; background: #000;"
           {{ $poster ? 'poster="' . $poster . '"' : '' }}
           {{ $controls ? 'controls' : '' }}
           {{ $autoplay ? 'autoplay muted' : '' }}
           playsinline>
        
        <!-- HLS primary source -->
        @php
            $hlsFile = $video->files->where('format', 'hls')->first();
            $mp4File = $video->files->where('format', 'mp4')->first();
        @endphp

        @if($hlsFile)
            <source src="{{ Storage::url($hlsFile->path) }}" type="application/x-mpegURL">
        @endif

        <!-- MP4 fallback -->
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
            Your browser doesn't support video playback.<br>
            Please try updating your browser.
        </p>
    </video>

    <!-- Floating title & back button -->
    <div class="position-absolute top-0 start-0 end-0 p-3 bg-gradient-to-b from-black/80 to-transparent text-white pointer-events-none z-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ url()->previous() ?? route('home') }}" 
               class="btn btn-dark btn-sm rounded-pill pointer-events-auto shadow">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
            <h5 class="mb-0 pointer-events-auto text-truncate ms-3">{{ $title }}</h5>
        </div>
    </div>
</div>

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
            if ({{ json_encode($autoplay) }}) {
                video.play().catch(e => console.warn('Autoplay prevented:', e));
            }
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
    // Native HLS support (Safari / iOS)
    else if (video.canPlayType('application/vnd.apple.mpegurl') && hlsSource) {
        video.src = hlsSource;
        console.log('Using native HLS');
        if ({{ json_encode($autoplay) }}) {
            video.play().catch(e => console.warn('Autoplay prevented:', e));
        }
    } else {
        console.warn('HLS not supported');
    }

    // Progress tracking (every 10 seconds)
    video.addEventListener('timeupdate', function () {
        const current = Math.floor(video.currentTime);
        if (current > 0 && current % 10 === 0) {
            fetch('{{ route("api.watch.progress") }}', {
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