<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    //
     public function index(Request $request)
    {
        $query = Movie::with(['video.genres', 'video.categories'])
            ->withCount('video as video_files_count');

        if ($request->has('genre')) {
            $genre = $request->query('genre');
            $query->whereHas('video.genres', function ($q) use ($genre) {
                $q->where('slug', $genre);
            });
        }

        $movies = $query->paginate(20);

        return response()->json($movies);
    }

    public function show($slug)
    {
        $movie = Movie::with([
                'video.genres',
                'video.categories',
                'video.files',
                'video.subtitles',
            ])
            ->whereHas('video', fn($q) => $q->where('slug', $slug))
            ->firstOrFail();

        return response()->json($movie);
    }
}
