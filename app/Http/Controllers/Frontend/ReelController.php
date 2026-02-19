<?php

// app/Http/Controllers/Frontend/ReelController.php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;

class ReelController extends Controller
{
    public function index()
    {
        $reels = Video::where('type', 'reel')->paginate(12);
        return view('frontend.reels.index', compact('reels'));
    }

    public function show($slug)
    {
        $reel = Video::where('type', 'reel')->where('slug', $slug)->with('reel', 'files', 'subtitles')->firstOrFail();
        $related = Video::where('type', 'reel')->where('id', '!=', $reel->id)->take(6)->get();
        return view('frontend.reels.show', compact('reel', 'related'));
    }
}