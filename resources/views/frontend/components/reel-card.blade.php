<div class="w-48 flex-shrink-0 bg-gray-800 rounded-lg overflow-hidden">
    <video src="{{ asset('storage/' . $reel->video->video_path) }}" controls class="w-full h-32 object-cover"></video>
    <div class="p-2">
        <h3 class="font-semibold">{{ $reel->video->title }}</h3>
    </div>
</div>
