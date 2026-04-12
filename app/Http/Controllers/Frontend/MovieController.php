<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Category;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    // ===================== WEB METHODS (पुराना, Blade view return गर्छन्) =====================

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

        $user = Auth::user();
        $continueWatching = ($user instanceof \App\Models\User) 
            ? $user->viewHistories()->with('video')->latest('last_watched_at')->take(6)->get()->pluck('video') 
            : collect();

        return view('frontend.movies.home', compact('featuredVideo', 'trendingMovies', 'popularShows', 'reels', 'continueWatching'));
    }

    public function index()
    {
        $videos = Video::where('type', 'movie')
            ->latest()
            ->paginate(20);

        $categories = Category::where('type', 'movie')->get();

        return view('frontend.movies.index', compact('videos', 'categories'));
    }

    public function show($slug)
    {
        $video = Video::where('type', 'movie')->where('slug', $slug)
            ->with(['genres', 'categories', 'files', 'subtitles', 'movie'])
            ->firstOrFail();

        $related = Video::where('type', 'movie')
            ->where('id', '!=', $video->id)
            ->take(8)
            ->get();

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

    // ===================== API METHODS (पूर्ण अपडेट) =====================

    /**
     * API: Get paginated list of movies
     * URL: GET /api/movies?page=1&per_page=20
     */
    public function indexApi(Request $request)
    {
        $perPage = $request->input('per_page', 20);

        $videos = Video::where('type', 'movie')
            ->with(['movie', 'files'])
            ->latest()
            ->paginate($perPage);

        $data = $videos->getCollection()->map(function ($video) {
            // Manually sort files by quality since SQLite doesn't support FIELD()
            $qualityOrder = ['1080p', '720p', '480p', '360p'];
            $bestFile = $video->files->sortBy(function($file) use ($qualityOrder) {
                $pos = array_search($file->quality, $qualityOrder);
                return $pos === false ? 999 : $pos;
            })->first();

            return [
                'id' => $video->id,
                'title' => $video->title,
                'slug' => $video->slug,
                'description' => $video->description,
                'poster' => $video->poster_path ? asset('storage/' . $video->poster_path) : null,
                'thumbnail' => $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : null,
                'video_url' => $bestFile ? asset('storage/' . $bestFile->path) : null,
                'hls_url' => $bestFile && $bestFile->format === 'hls' ? asset('storage/' . $bestFile->path) : null,
                'duration' => $video->duration_sec ?? 'N/A',
                'rating' => $video->rating ?? 'N/A',
                'year' => $video->release_date ? $video->release_date->year : 'N/A',
                'is_premium' => $video->movie ? $video->movie->is_premium : false,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'pagination' => [
                'current_page' => $videos->currentPage(),
                'last_page' => $videos->lastPage(),
                'per_page' => $videos->perPage(),
                'total' => $videos->total(),
            ]
        ]);
    }

    /**
     * API: Get single movie details
     * URL: GET /api/movies/{slug}
     */
    public function showApi($slug)
    {
        $video = Video::where('type', 'movie')
            ->where('slug', $slug)
            ->with([
                'genres',
                'categories',
                'files',
                'subtitles',
                'movie'
            ])
            ->firstOrFail();

        // Manually sort files by quality since SQLite doesn't support FIELD()
        $qualityOrder = ['1080p', '720p', '480p', '360p'];
        $bestFile = $video->files->sortBy(function($file) use ($qualityOrder) {
            $pos = array_search($file->quality, $qualityOrder);
            return $pos === false ? 999 : $pos;
        })->first();

        $related = Video::where('type', 'movie')
            ->where('id', '!=', $video->id)
            ->take(8)
            ->get()
            ->map(function ($rel) {
                return [
                    'id' => $rel->id,
                    'title' => $rel->title,
                    'slug' => $rel->slug,
                    'poster' => $rel->poster_path ? asset('storage/' . $rel->poster_path) : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => array_merge($video->toArray(), [
                'id' => $video->id,
                'title' => $video->title,
                'slug' => $video->slug,
                'description' => $video->description,
                'poster' => $video->poster_path ? asset('storage/' . $video->poster_path) : null,
                'thumbnail' => $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : null,
                'video_url' => $bestFile ? asset('storage/' . $bestFile->path) : null,
                'hls_url' => $bestFile && $bestFile->format === 'hls' ? asset('storage/' . $bestFile->path) : null,
                'duration' => $video->duration_sec ?? 'N/A',
                'rating' => $video->rating ?? 'N/A',
                'year' => $video->release_date ? $video->release_date->year : 'N/A',
                'is_premium' => $video->movie ? $video->movie->is_premium : false,
                'genres' => $video->genres->pluck('name'),
                'categories' => $video->categories->pluck('name'),
                'files' => $video->files->map(function ($file) {
                    return [
                        'quality' => $file->quality,
                        'format' => $file->format,
                        'url' => asset('storage/' . $file->path),
                    ];
                }),
                'subtitles' => $video->subtitles->map(function ($sub) {
                    return [
                        'language' => $sub->language ?? 'en',
                        'url' => asset('storage/' . $sub->path),
                    ];
                }),
                'related' => $related,
            ])
        ]);
    }

    /**
     * API: Movies by category
     * URL: GET /api/movies/category/{category}
     */
    public function categoryApi($category)
    {
        $category = Category::where('slug', $category)->firstOrFail();
        $perPage = request()->input('per_page', 20);

        $videos = $category->videos()
            ->where('type', 'movie')
            ->with(['movie', 'files'])
            ->paginate($perPage);

        $data = $videos->through(function ($video) {
            $bestFile = $video->files->first();
            return [
                'id' => $video->id,
                'title' => $video->title,
                'slug' => $video->slug,
                'poster' => $video->poster_path ? asset('storage/' . $video->poster_path) : null,
                'video_url' => $bestFile ? asset('storage/' . $bestFile->path) : null,
                'hls_url' => $bestFile && $bestFile->format === 'hls' ? asset('storage/' . $bestFile->path) : null,
                'rating' => $video->rating ?? 'N/A',
                'year' => $video->release_date ? $video->release_date->year : 'N/A',
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'pagination' => [
                'current_page' => $videos->currentPage(),
                'last_page' => $videos->lastPage(),
                'per_page' => $videos->perPage(),
                'total' => $videos->total(),
            ]
        ]);
    }

    /**
     * API: Search movies
     * URL: GET /api/search?q=keyword
     */
    public function searchApi(Request $request)
    {
        $query = $request->input('q');
        $perPage = $request->input('per_page', 20);

        $results = Video::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('type', 'movie')
            ->with(['movie', 'files'])
            ->paginate($perPage);

        $data = $results->through(function ($video) {
            $bestFile = $video->files->first();
            return [
                'id' => $video->id,
                'title' => $video->title,
                'slug' => $video->slug,
                'poster' => $video->poster_path ? asset('storage/' . $video->poster_path) : null,
                'video_url' => $bestFile ? asset('storage/' . $bestFile->path) : null,
                'hls_url' => $bestFile && $bestFile->format === 'hls' ? asset('storage/' . $bestFile->path) : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
            ]
        ]);
    }
}