<?php

// app/Http/Controllers/Frontend/MovieController.php (home, index, show, category, search)
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Movie;
use App\Models\Category;
use App\Models\TvShow;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function home()
    {
        $featuredVideo = Video::where('type', 'movie')
            ->whereHas('movie', fn($q) => $q->where('is_premium', true))
            ->latest('release_date')
            ->first();

        $trendingMovies = Video::where('type', 'movie')
            ->withCount('viewHistories')
            ->orderByDesc('view_histories_count')
            ->take(10)
            ->get();

        $popularShows = TvShow::withCount('seasons')
            ->orderByDesc('seasons_count')
            ->take(10)
            ->get();

        $reels = Video::where('type', 'reel')
            ->latest()
            ->take(8)
            ->get();

        $continueWatching = auth()->check() ? auth()->user()->viewHistories()->with('video')->latest('last_watched_at')->take(6)->get()->pluck('video') : collect();

        return view('frontend.movies.home', compact('featuredVideo', 'trendingMovies', 'popularShows', 'reels', 'continueWatching'));
    }

    public function index()
    {
        $movies = Video::where('type', 'movie')->paginate(20);
        $categories = Category::where('type', 'movie')->get();
        return view('frontend.movies.index', compact('movies', 'categories'));
    }

    public function show($slug)
    {
        $video = Video::where('type', 'movie')->where('slug', $slug)->with(['genres', 'categories', 'files', 'subtitles', 'movie'])->firstOrFail();
        $related = Video::where('type', 'movie')->where('id', '!=', $video->id)->take(8)->get();
        return view('frontend.movies.show', compact('video', 'related'));
    }

    public function category($category)
    {
        $category = Category::where('slug', $category)->firstOrFail();
        $movies = $category->videos()->where('type', 'movie')->paginate(20);
        return view('frontend.movies.category', compact('category', 'movies'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $results = Video::where('title', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%')
            ->paginate(20);

        return view('frontend.search', compact('results', 'query'));
    }
}