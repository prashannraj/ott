<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    // ===================== WEB METHODS (पुराना, Blade view return गर्छन्) =====================

    public function index()
    {
        $reels = Video::where('type', 'reel')
            ->latest()
            ->paginate(20);

        return view('frontend.reels.index', compact('reels'));
    }

    public function show($slug)
    {
        $reel = Video::where('type', 'reel')
            ->where('slug', $slug)
            ->with('reel', 'files', 'subtitles')
            ->firstOrFail();

        $related = Video::where('type', 'reel')
            ->where('id', '!=', $reel->id)
            ->take(6)
            ->get();

        return view('frontend.reels.show', compact('reel', 'related'));
    }

    // ===================== API METHODS (नयाँ, JSON return गर्छन्) =====================

    /**
     * API: Get paginated list of reels
     * URL: /api/reels?page=1&per_page=20
     */
    public function indexApi(Request $request)
    {
        $perPage = $request->query('per_page', 20);

        $reels = Video::where('type', 'reel')
            ->latest()
            ->paginate($perPage);

        $data = $reels->map(function ($reel) {
            return [
                'id' => $reel->id,
                'title' => $reel->title,
                'slug' => $reel->slug,
                'thumbnail' => $reel->thumbnail ? asset('storage/' . $reel->thumbnail) : null,
                'duration' => $reel->duration ?? 'N/A',
                'views' => $reel->view_count ?? 0,
                'created_at' => $reel->created_at->format('Y-m-d'),
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'pagination' => [
                'current_page' => $reels->currentPage(),
                'last_page' => $reels->lastPage(),
                'per_page' => $reels->perPage(),
                'total' => $reels->total(),
            ]
        ]);
    }

    /**
     * API: Get single reel details by slug
     * URL: /api/reels/{slug}
     */
    public function showApi($slug)
    {
        $reel = Video::where('type', 'reel')
            ->where('slug', $slug)
            ->with(['reel', 'files', 'subtitles'])
            ->firstOrFail();

        $related = Video::where('type', 'reel')
            ->where('id', '!=', $reel->id)
            ->take(6)
            ->get()
            ->map(function ($rel) {
                return [
                    'id' => $rel->id,
                    'title' => $rel->title,
                    'slug' => $rel->slug,
                    'thumbnail' => $rel->thumbnail ? asset('storage/' . $rel->thumbnail) : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'reel' => [
                    'id' => $reel->id,
                    'title' => $reel->title,
                    'slug' => $reel->slug,
                    'description' => $reel->description ?? null,
                    'thumbnail' => $reel->thumbnail ? asset('storage/' . $reel->thumbnail) : null,
                    'video_url' => $reel->video_url ?? null,
                    'hls_url' => $reel->hls_url ?? null,
                    'duration' => $reel->duration ?? 'N/A',
                    'views' => $reel->view_count ?? 0,
                    'files' => $reel->files->map(function ($file) {
                        return [
                            'url' => asset('storage/' . $file->path),
                            'type' => $file->type ?? 'video/mp4',
                        ];
                    }),
                    'subtitles' => $reel->subtitles->map(function ($sub) {
                        return [
                            'lang' => $sub->language ?? 'en',
                            'url' => asset('storage/' . $sub->path),
                        ];
                    }),
                ],
                'related_reels' => $related,
            ]
        ]);
    }
}