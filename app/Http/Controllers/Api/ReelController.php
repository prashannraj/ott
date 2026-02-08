<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reel;

class ReelController extends Controller
{
    //
    public function feed(Request $request)
    {
        $reels = Reel::with('video')
            ->latest()
            ->paginate(20);

        return response()->json($reels);
    }
}
