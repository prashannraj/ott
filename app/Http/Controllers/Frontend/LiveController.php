<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LiveChannel;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    // ===================== WEB METHODS (पुराना, Blade view return गर्छन्) =====================

    public function index()
    {
        $channels = LiveChannel::with('streams')
            ->whereHas('streams', fn($q) => $q->where('is_active', true))
            ->get();

        return view('frontend.live.index', compact('channels'));
    }

    public function show($slug)
    {
        $channel = LiveChannel::where('slug', $slug)
            ->with('streams')
            ->firstOrFail();

        $stream = $channel->streams->first(); // पहिलो active stream लिने (वा logic अनुसार change गर्न सकिन्छ)

        return view('frontend.live.show', compact('channel', 'stream'));
    }

    // ===================== API METHODS (नयाँ, JSON return गर्छन्) =====================

    /**
     * API: Get list of active live channels
     * URL: /api/live
     */
    public function indexApi(Request $request)
    {
        $channels = LiveChannel::with(['streams' => function ($q) {
            $q->where('is_active', true);
        }])
            ->whereHas('streams', fn($q) => $q->where('is_active', true))
            ->get()
            ->map(function ($channel) {
                return [
                    'id' => $channel->id,
                    'title' => $channel->title,
                    'slug' => $channel->slug,
                    'description' => $channel->description,
                    'thumbnail' => $channel->thumbnail ? asset('storage/' . $channel->thumbnail) : null,
                    'logo' => $channel->logo ? asset('storage/' . $channel->logo) : null,
                    'streams' => $channel->streams->map(function ($stream) {
                        return [
                            'id' => $stream->id,
                            'title' => $stream->title,
                            'url' => $stream->url,
                            'is_active' => $stream->is_active,
                            'quality' => $stream->quality ?? 'HD',
                        ];
                    }),
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $channels
        ]);
    }

    /**
     * API: Get single live channel details by slug
     * URL: /api/live/{slug}
     */
    public function showApi($slug)
    {
        $channel = LiveChannel::where('slug', $slug)
            ->with(['streams' => function ($q) {
                $q->where('is_active', true);
            }])
            ->firstOrFail();

        if ($channel->streams->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No active stream found for this channel'
            ], 404);
        }

        $stream = $channel->streams->first(); // पहिलो active stream

        return response()->json([
            'status' => 'success',
            'data' => array_merge($channel->toArray(), [
                'id' => $channel->id,
                'title' => $channel->title,
                'slug' => $channel->slug,
                'description' => $channel->description,
                'thumbnail' => $channel->thumbnail ? asset('storage/' . $channel->thumbnail) : null,
                'logo' => $channel->logo ? asset('storage/' . $channel->logo) : null,
                'category' => $channel->category ?? 'General',
                'active_stream' => [
                    'id' => $stream->id,
                    'title' => $stream->title,
                    'url' => $stream->url,
                    'quality' => $stream->quality ?? 'HD',
                    'is_active' => $stream->is_active,
                ],
                'all_streams' => $channel->streams->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'title' => $s->title,
                        'url' => $s->url,
                        'quality' => $s->quality ?? 'HD',
                    ];
                }),
            ])
        ]);
    }
}