<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\WatchlistController;
use App\Http\Controllers\Api\StreamController;
use App\Http\Controllers\Api\LiveController;
use App\Http\Controllers\Api\ReelController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\SubscriptionPlanController;
use App\Http\Controllers\Api\AnalyticsController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
    });
    // Route::post('/register', [RegisteredUserController::class, 'store']);
    // Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->group(function () {
//     // Movies
//     Route::get('movies', [MovieController::class, 'index']);
//     Route::get('movies/{slug}', [MovieController::class, 'show']);

//     // Watchlist
//     Route::get('watchlist', [WatchlistController::class, 'index']);
//     Route::post('watchlist/{video}', [WatchlistController::class, 'store']);
//     Route::delete('watchlist/{video}', [WatchlistController::class, 'destroy']);

//     // Streaming
//     Route::get('stream/{video}', [StreamController::class, 'getPlaybackUrl']);

//     // Live TV
//     Route::get('live/channels', [LiveController::class, 'index']);
//     Route::get('live/channels/{slug}', [LiveController::class, 'show']);

//     // Reels
//     Route::get('reels/feed', [ReelController::class, 'feed']);

//     // Subscriptions
//     Route::get('plans', [SubscriptionPlanController::class, 'index']);
//     Route::post('subscriptions', [SubscriptionController::class, 'store']); // create subscription (after payment)
//     Route::get('subscriptions/me', [SubscriptionController::class, 'me']);

//     // Analytics
//     Route::post('analytics/play', [AnalyticsController::class, 'logPlay']);


// });

// PUBLIC ROUTES
Route::get('movies', [MovieController::class, 'index']);
Route::get('movies/{slug}', [MovieController::class, 'show']);
Route::get('live/channels', [LiveController::class, 'index']);
Route::get('reels/feed', [ReelController::class, 'feed']);
Route::get('plans', [SubscriptionPlanController::class, 'index']);


// PROTECTED ROUTES
Route::middleware('auth:sanctum')->group(function () {

    Route::get('watchlist', [WatchlistController::class, 'index']);
    Route::post('watchlist/{video}', [WatchlistController::class, 'store']);
    Route::delete('watchlist/{video}', [WatchlistController::class, 'destroy']);

    Route::get('stream/{video}', [StreamController::class, 'getPlaybackUrl']);

    Route::post('subscriptions', [SubscriptionController::class, 'store']);
    Route::get('subscriptions/me', [SubscriptionController::class, 'me']);

    Route::post('analytics/play', [AnalyticsController::class, 'logPlay']);
});

