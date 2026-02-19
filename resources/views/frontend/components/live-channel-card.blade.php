@props(['channel'])

<div class="live-channel-card rounded overflow-hidden shadow bg-dark position-relative">
    <a href="{{ route('live.watch', $channel->slug ?? $channel->id) }}" class="text-decoration-none">
        <div class="ratio ratio-16x9 position-relative">
            <img src="{{ $channel->logo_url ?? $channel->thumbnail_url ?? asset('images/channel-placeholder.jpg') }}"
                 alt="{{ $channel->name }}"
                 class="object-fit-cover">

            <div class="position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-center justify-content-center bg-black bg-opacity-40 hover-bg-opacity-20 transition">
                <i class="fas fa-play-circle fa-4x text-danger opacity-90"></i>
            </div>

            <div class="position-absolute top-2 end-2 badge bg-danger px-2 py-1 text-xs live-badge animate-pulse">
                LIVE
            </div>
        </div>

        <div class="p-3">
            <h6 class="mb-1 fw-semibold text-truncate">{{ $channel->name }}</h6>
            <small class="text-white-50 d-block text-truncate">{{ $channel->category?->name ?? 'Entertainment' }}</small>
        </div>
    </a>
</div>

<style>
    .live-badge {
        font-size: 0.75rem;
        font-weight: 700;
    }
</style>