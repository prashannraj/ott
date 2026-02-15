<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Video;
use App\Models\Reel;

class FrontendController extends Controller
{
    //
    public function home()
    {
        $heroMovie = Movie::with('video')->latest()->first();
        $trendingMovies = Movie::with('video')->take(10)->get();
        $latestMovies = Movie::with('video')->latest()->paginate(12);
        $reels = Reel::with('video')->latest()->take(8)->get();

        return view('frontend.home', compact('heroMovie', 'trendingMovies', 'latestMovies', 'reels'));
    }

    public function movieDetail($slug)
    {
        $movie = Movie::with('video')->whereHas('video', fn($q)=> $q->where('slug', $slug))->firstOrFail();
        return view('frontend.movies.show', compact('movie'));
    }
}
