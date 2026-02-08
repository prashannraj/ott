<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StreamController extends Controller
{
    //
    public function getPlaybackUrl(Request $request, Video $video)
    {
        $user = $request->user();

        if (! $this->canWatch($user, $video)) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        $file = $video->files()
            ->where('format', 'hls')
            ->orderByDesc('quality')
            ->first();

        if (! $file) {
            return response()->json(['message' => 'Stream not available'], 404);
        }

        // Example: stored on s3
        $url = Storage::disk('s3')->url($file->path);

        return response()->json([
            'playback_url' => $url,
            'subtitles' => $video->subtitles()->get(['language_code','label','file_path']),
        ]);
    }

    protected function canWatch(User $user, Video $video): bool
    {
        // Free content example: if video.movie->is_premium == false
        if ($video->type === 'movie' && $video->movie && ! $video->movie->is_premium) {
            return true;
        }

        // Check active subscription
        $hasActiveSub = $user->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>=', now())
            ->exists();

        // Or has active rental
        $hasRental = $user->rentals()
            ->where('video_id', $video->id)
            ->where('expires_at', '>=', now())
            ->exists();

        return $hasActiveSub || $hasRental;
    }
}
