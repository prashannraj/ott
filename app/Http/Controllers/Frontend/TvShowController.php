<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use App\Models\Season;
use Illuminate\Http\Request;

class TvShowController extends Controller
{
    // ===================== WEB METHODS (पुराना, Blade view return गर्छन्) =====================

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

    // ===================== API METHODS (नयाँ, JSON return गर्छन्) =====================

    /**
     * API: Get paginated list of TV shows
     * URL: /api/shows?page=1&per_page=20
     * Method: GET
     */
    public function indexApi(Request $request)
    {
        $perPage = $request->query('per_page', 20);

        $shows = TvShow::withCount('seasons')
            ->paginate($perPage);

        $data = $shows->map(function ($show) {
            return [
                'id' => $show->id,
                'title' => $show->title,
                'slug' => $show->slug,
                'poster' => $show->poster ? asset('storage/' . $show->poster) : null,
                'thumbnail' => $show->thumbnail ? asset('storage/' . $show->thumbnail) : null,
                'description' => $show->description ?? null,
                'seasons_count' => $show->seasons_count,
                'rating' => $show->rating ?? 'N/A',
                'year' => $show->year ?? 'N/A',
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'pagination' => [
                'current_page' => $shows->currentPage(),
                'last_page' => $shows->lastPage(),
                'per_page' => $shows->perPage(),
                'total' => $shows->total(),
            ]
        ]);
    }

    /**
     * API: Get single TV show details by slug
     * URL: /api/shows/{slug}
     * Method: GET
     */
    public function showApi($slug)
    {
        $show = TvShow::where('slug', $slug)
            ->with('seasons.episodes.video')
            ->firstOrFail();

        $seasons = $show->seasons->map(function ($season) {
            return [
                'id' => $season->id,
                'season_number' => $season->season_number,
                'title' => $season->title ?? "Season {$season->season_number}",
                'episodes_count' => $season->episodes->count(),
                'episodes' => $season->episodes->map(function ($episode) {
                    return [
                        'id' => $episode->id,
                        'title' => $episode->title,
                        'episode_number' => $episode->episode_number,
                        'thumbnail' => $episode->thumbnail ? asset('storage/' . $episode->thumbnail) : null,
                        'video_url' => $episode->video->video_url ?? null,
                        'hls_url' => $episode->video->hls_url ?? null,
                        'duration' => $episode->video->duration ?? 'N/A',
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => array_merge($show->toArray(), [
                'id' => $show->id,
                'title' => $show->title,
                'slug' => $show->slug,
                'poster' => $show->poster ? asset('storage/' . $show->poster) : null,
                'thumbnail' => $show->thumbnail ? asset('storage/' . $show->thumbnail) : null,
                'description' => $show->description,
                'rating' => $show->rating ?? 'N/A',
                'year' => $show->year ?? 'N/A',
                'seasons' => $seasons,
            ])
        ]);
    }

    /**
     * API: Get episodes of a specific season
     * URL: /api/shows/{slug}/season/{seasonNumber}
     * Method: GET
     */
    public function seasonApi($slug, $seasonNumber)
    {
        $show = TvShow::where('slug', $slug)->firstOrFail();

        $season = Season::where('tv_show_id', $show->id)
            ->where('season_number', $seasonNumber)
            ->with('episodes.video')
            ->firstOrFail();

        $episodes = $season->episodes->map(function ($episode) {
            return [
                'id' => $episode->id,
                'title' => $episode->title,
                'episode_number' => $episode->episode_number,
                'thumbnail' => $episode->thumbnail ? asset('storage/' . $episode->thumbnail) : null,
                'video_url' => $episode->video->video_url ?? null,
                'hls_url' => $episode->video->hls_url ?? null,
                'duration' => $episode->video->duration ?? 'N/A',
                'description' => $episode->description ?? null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'show' => [
                    'id' => $show->id,
                    'title' => $show->title,
                    'slug' => $show->slug,
                ],
                'season' => [
                    'id' => $season->id,
                    'season_number' => $season->season_number,
                    'title' => $season->title ?? "Season {$season->season_number}",
                    'episodes' => $episodes,
                ]
            ]
        ]);
    }
}