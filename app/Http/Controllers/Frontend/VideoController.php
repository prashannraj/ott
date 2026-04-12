<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    // ===================== WEB METHODS (पुराना, Blade view return गर्छन्) =====================

    public function show($slug)
    {
        $video = Video::where('slug', $slug)
            ->with(['genres', 'categories', 'files', 'subtitles', 'movie', 'episode.season.tvShow', 'reel'])
            ->firstOrFail();

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
        if ($video->movie?->is_premium) {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Premium content - Login required');
            }
            if (!Auth::user()->isPremium()) {
                return redirect()->route('subscriptions.index')->with('error', 'This is premium content. Please upgrade your plan to watch.');
            }
        }

        // Save watch history
        if (Auth::check()) {
            Auth::user()->viewHistories()->updateOrCreate(
                ['video_id' => $video->id],
                ['last_position_sec' => 0, 'last_watched_at' => now()]
            );
        }

        // Related videos (same logic)
        $related = Video::where('type', $video->type)
            ->where('id', '!=', $video->id)
            ->whereHas('genres', fn($q) => $q->whereIn('genres.id', $video->genres->pluck('id')))
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('frontend.watch', compact('video', 'related'));
    }

    // ===================== API METHODS (नयाँ, JSON return गर्छन्) =====================

    /**
     * API: Get single video details by slug
     * URL: /api/videos/{slug}
     * Method: GET
     */
    public function showApi($slug)
    {
        $video = Video::where('slug', $slug)
            ->with(['genres', 'categories', 'files', 'subtitles', 'movie', 'episode.season.tvShow', 'reel'])
            ->first();

        if (!$video) {
            return response()->json([
                'status' => 'error',
                'message' => 'Video not found or not available'
            ], 404);
        }

        $related = Video::where('type', $video->type)
            ->where('id', '!=', $video->id)
            ->whereHas('genres', fn($q) => $q->whereIn('genres.id', $video->genres->pluck('id')))
            ->inRandomOrder()
            ->take(8)
            ->get()
            ->map(function ($rel) {
                return [
                    'id' => $rel->id,
                    'title' => $rel->title,
                    'slug' => $rel->slug,
                    'type' => $rel->type,
                    'poster' => $rel->poster ? asset('storage/' . $rel->poster) : null,
                    'thumbnail' => $rel->thumbnail ? asset('storage/' . $rel->thumbnail) : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => array_merge($video->toArray(), [
                'id' => $video->id,
                'title' => $video->title,
                'slug' => $video->slug,
                'type' => $video->type,
                'description' => $video->description ?? null,
                'poster' => $video->poster ? asset('storage/' . $video->poster) : null,
                'thumbnail' => $video->thumbnail ? asset('storage/' . $video->thumbnail) : null,
                'duration' => $video->duration ?? 'N/A',
                'release_date' => $video->release_date ? $video->release_date->format('Y-m-d') : null,
                'rating' => $video->rating ?? 'N/A',
                'genres' => $video->genres->pluck('name'),
                'categories' => $video->categories->pluck('name'),
                'video_url' => $video->video_url ?? null,
                'hls_url' => $video->hls_url ?? null,
                'files' => $video->files->map(function ($file) {
                    return [
                        'id' => $file->id,
                        'url' => asset('storage/' . $file->path),
                        'type' => $file->type ?? 'video/mp4',
                        'quality' => $file->quality ?? 'HD',
                    ];
                }),
                'subtitles' => $video->subtitles->map(function ($sub) {
                    return [
                        'id' => $sub->id,
                        'language' => $sub->language ?? 'en',
                        'url' => asset('storage/' . $sub->path),
                    ];
                }),
                'movie' => $video->movie ? [
                    'id' => $video->movie->id,
                    'title' => $video->movie->title,
                ] : null,
                'episode' => $video->episode ? [
                    'id' => $video->episode->id,
                    'title' => $video->episode->title,
                    'episode_number' => $video->episode->episode_number,
                    'season' => $video->episode->season ? [
                        'id' => $video->episode->season->id,
                        'season_number' => $video->episode->season->season_number,
                        'tv_show' => $video->episode->season->tvShow ? [
                            'id' => $video->episode->season->tvShow->id,
                            'title' => $video->episode->season->tvShow->title,
                        ] : null,
                    ] : null,
                ] : null,
                'related_videos' => $related,
            ])
        ]);
    }

    /**
     * API: Get watch-ready video details (premium check सहित)
     * URL: /api/watch/{slug}
     * Method: GET
     * Requires: auth:sanctum (premium content को लागि)
     */
    public function watchApi($slug)
    {
        $video = Video::where('slug', $slug)
            ->with(['files', 'subtitles'])
            ->first();

        if (!$video) {
            return response()->json([
                'status' => 'error',
                'message' => 'Video not found'
            ], 404);
        }

        // Premium check
        if ($video->movie?->is_premium) {
            if (!Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Premium content - Login required'
                ], 403);
            }
            if (!Auth::user()->isPremium()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Premium content - Upgrade required'
                ], 403);
            }
        }

        // Save watch history (auth user को लागि)
        if (Auth::check()) {
            Auth::user()->viewHistories()->updateOrCreate(
                ['video_id' => $video->id],
                ['last_position_sec' => 0, 'last_watched_at' => now()]
            );
        }

        // Related videos
        $related = Video::where('type', $video->type)
            ->where('id', '!=', $video->id)
            ->whereHas('genres', fn($q) => $q->whereIn('genres.id', $video->genres->pluck('id')))
            ->inRandomOrder()
            ->take(6)
            ->get()
            ->map(function ($rel) {
                return [
                    'id' => $rel->id,
                    'title' => $rel->title,
                    'slug' => $rel->slug,
                    'poster' => $rel->poster ? asset('storage/' . $rel->poster) : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'video' => [
                    'id' => $video->id,
                    'title' => $video->title,
                    'slug' => $video->slug,
                    'type' => $video->type,
                    'description' => $video->description ?? null,
                    'poster' => $video->poster ? asset('storage/' . $video->poster) : null,
                    'video_url' => $video->video_url ?? null,
                    'hls_url' => $video->hls_url ?? null,
                    'duration' => $video->duration ?? 'N/A',
                    'files' => $video->files->map(function ($file) {
                        return [
                            'url' => asset('storage/' . $file->path),
                            'type' => $file->type ?? 'video/mp4',
                            'quality' => $file->quality ?? 'HD',
                        ];
                    }),
                    'subtitles' => $video->subtitles->map(function ($sub) {
                        return [
                            'language' => $sub->language ?? 'en',
                            'url' => asset('storage/' . $sub->path),
                        ];
                    }),
                ],
                'related_videos' => $related,
            ]
        ]);
    }
}