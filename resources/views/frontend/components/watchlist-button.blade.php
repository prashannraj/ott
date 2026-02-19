@props([
    'item',
    'type' => 'movie', // movie | show | episode
])

<button class="btn btn-sm btn-outline-light watchlist-btn rounded-circle p-2"
        data-type="{{ $type }}"
        data-id="{{ $item->id }}"
        title="Add to My List">
    <i class="far fa-heart fa-lg"></i>
</button>

@push('scripts')
<script>
document.querySelectorAll('.watchlist-btn').forEach(btn => {
    btn.addEventListener('click', async function(e) {
        e.preventDefault();
        const icon = this.querySelector('i');
        const isAdded = icon.classList.contains('fas');

        try {
            const response = await fetch('/api/watchlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    type: this.dataset.type,
                    id: this.dataset.id
                })
            });

            if (response.ok) {
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                icon.classList.toggle('text-danger');
                // optional toast notification
            }
        } catch (err) {
            console.error('Watchlist toggle failed', err);
        }
    });
});
</script>
@endpush