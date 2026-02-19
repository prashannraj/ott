<?php

// app/Http/Controllers/Frontend/LiveController.php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LiveChannel;

class LiveController extends Controller
{
    public function index()
    {
        $channels = LiveChannel::with('streams')->whereHas('streams', fn($q) => $q->where('is_active', true))->get();
        return view('frontend.live.index', compact('channels'));
    }

    public function show($slug)
    {
        $channel = LiveChannel::where('slug', $slug)->with('streams')->firstOrFail();
        $stream = $channel->streams->first();
        return view('frontend.live.show', compact('channel', 'stream'));
    }
}