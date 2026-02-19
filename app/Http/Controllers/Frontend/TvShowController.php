<?php

// app/Http/Controllers/Frontend/TvShowController.php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use App\Models\Season;
use Illuminate\Http\Request;

class TvShowController extends Controller
{
    public function index()
    {
        $shows = TvShow::withCount('seasons')->paginate(20);
        return view('frontend.shows.index', compact('shows'));
    }

    public function show($slug)
    {
        $show = TvShow::where('slug', $slug)->with('seasons')->firstOrFail();
        $activeSeason = $show->seasons->first();
        return view('frontend.shows.show', compact('show', 'activeSeason'));
    }

    public function season($slug, $seasonNumber)
    {
        $show = TvShow::where('slug', $slug)->firstOrFail();
        $activeSeason = Season::where('tv_show_id', $show->id)
            ->where('season_number', $seasonNumber)
            ->with('episodes.video')
            ->firstOrFail();

        return view('frontend.shows.show', compact('show', 'activeSeason'));
    }
}