<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewHistory;

class WatchProgressController extends Controller
{
    public function update(Request $request)
    {
        // Validation
        $request->validate([
            'video_id'     => 'required|exists:videos,id',
            'position_sec' => 'required|integer|min:0',
            'duration_sec' => 'nullable|integer|min:0',
        ]);

        $user = $request->user();

        // यदि user logged in छैन भने error
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Progress save / update
        ViewHistory::updateOrCreate(
            [
                'user_id'  => $user->id,
                'video_id' => $request->video_id,
            ],
            [
                'last_position_sec' => $request->position_sec,
                'last_watched_at'   => now(),
                'duration_sec'      => $request->duration_sec,
                'completed'         => $request->position_sec >= ($request->duration_sec * 0.95 ?? 1), // 95% हेरे completed
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Progress saved'
        ]);
    }
}