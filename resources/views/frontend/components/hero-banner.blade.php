<div class="relative h-96 rounded-lg overflow-hidden">
    <img src="{{ asset('storage/' . $movie->video->banner_path) }}" class="w-full h-full object-cover">
    <div class="absolute bottom-4 left-4">
        <h1 class="text-3xl font-bold">{{ $movie->video->title }}</h1>
        <p class="text-gray-200 max-w-xl">{{ Str::limit(strip_tags($movie->video->description), 150) }}</p>
    </div>
</div>
