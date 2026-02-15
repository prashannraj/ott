<div class="w-48 flex-shrink-0 bg-gray-800 rounded-lg overflow-hidden">
    <a href="{{ url('movies/' . $movie->video->slug) }}">
        <img src="{{ asset('storage/' . $movie->video->thumbnail_path) }}" class="w-full h-32 object-cover">
        <div class="p-2">
            <h3 class="font-semibold">{{ $movie->video->title }}</h3>
            <p class="text-sm text-gray-400">{{ $movie->video->age_rating }}</p>
        </div>
    </a>
</div>
