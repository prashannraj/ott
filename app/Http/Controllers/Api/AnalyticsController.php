<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlayEvent;

class AnalyticsController extends Controller
{
    //
     public function logPlay(Request $request)
    {
        $data = $request->validate([
            'video_id' => 'required|exists:videos,id',
            'device_type' => 'nullable|string',
            'platform' => 'nullable|string',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'duration_sec' => 'nullable|integer',
        ]);

        $data['user_id'] = $request->user()->id ?? null;
        $data['ip_address'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        $event = PlayEvent::create($data);

        return response()->json([
            'message' => 'Play event logged',
            'event' => $event,
        ], 201);
    }
}
