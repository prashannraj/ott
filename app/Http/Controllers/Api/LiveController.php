<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveChannel;

class LiveController extends Controller
{
    //
    public function index(Request $request)
    {
        $channels = LiveChannel::with('category')
            ->with(['streams' => function ($q) {
                $q->where('is_active', true);
            }])
            ->paginate(50);

        return response()->json($channels);
    }

    public function show($slug)
    {
        $channel = LiveChannel::with(['category', 'streams' => function ($q) {
                $q->where('is_active', true);
            }])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($channel);
    }
}
