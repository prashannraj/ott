<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Watchlist;

class WatchlistController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = $request->user();

        $items = Watchlist::with('video')
            ->where('user_id', $user->id)
            ->paginate(20);

        return response()->json($items);
    }

    public function store(Request $request, Video $video)
    {
        $user = $request->user();

        $item = Watchlist::firstOrCreate([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);

        return response()->json([
            'message' => 'Added to watchlist',
            'item' => $item,
        ], 201);
    }

    public function destroy(Request $request, Video $video)
    {
        $user = $request->user();

        Watchlist::where('user_id', $user->id)
            ->where('video_id', $video->id)
            ->delete();

        return response()->json([
            'message' => 'Removed from watchlist',
        ]);
    }
}
