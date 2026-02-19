<?php

// app/Http/Controllers/Frontend/VideoController.php (पुरानो अपडेट गरिएको)
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show($slug)
    {
        $video = Video::where('slug', $slug)->with(['genres', 'categories', 'files', 'subtitles', 'movie', 'episode.season.tvShow', 'reel'])->firstOrFail();
        $related = Video::where('type', $video->type)
            ->where('id', '!=', $video->id)
            ->whereHas('genres', fn($q) => $q->whereIn('genres.id', $video->genres->pluck('id')))
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('frontend.videos.show', compact('video', 'related'));
    }

    public function watch($slug)
    {
        $video = Video::where('slug', $slug)
            ->with(['files', 'subtitles'])
            ->firstOrFail();

        // Premium check
        if ($video->movie?->is_premium && !auth()->check()) {
            return redirect()->route('login')->with('error', 'Premium content - Login required');
        }

        // Save history
        if (auth()->check()) {
            auth()->user()->viewHistories()->updateOrCreate(
                ['video_id' => $video->id],
                ['last_position_sec' => 0, 'last_watched_at' => now()]
            );
        }

        // Add related (same logic as show method)
        $related = Video::where('type', $video->type)
            ->where('id', '!=', $video->id)
            ->whereHas('genres', fn($q) => $q->whereIn('genres.id', $video->genres->pluck('id')))
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('frontend.watch', compact('video', 'related'));
    }
}