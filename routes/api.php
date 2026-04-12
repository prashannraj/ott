<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers import
use App\Http\Controllers\Frontend\MovieController;
use App\Http\Controllers\Frontend\TvShowController;
use App\Http\Controllers\Frontend\ReelController;
use App\Http\Controllers\Frontend\LiveController;
use App\Http\Controllers\Frontend\SubscriptionController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\VideoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\WatchProgressController;
use App\Http\Controllers\Api\PageController;

// Sanctum authentication routes (login/logout/register)
Route::post('/login', [AuthenticatedSessionController::class, 'storeApi'])->name('api.login');
Route::post('/register', [RegisteredUserController::class, 'storeApi'])->name('api.register');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroyApi'])->middleware('auth:sanctum')->name('api.logout');

// User info (logged-in user को detail)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'data' => $request->user()
    ]);
});

// Public APIs (login बिना पनि चल्छन्)
Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'indexApi'])->name('api.movies.index');
    Route::get('/{slug}', [MovieController::class, 'showApi'])->name('api.movies.show');
    Route::get('/category/{category}', [MovieController::class, 'categoryApi'])->name('api.movies.category');
});

Route::prefix('shows')->group(function () {
    Route::get('/', [TvShowController::class, 'indexApi'])->name('api.shows.index');
    Route::get('/{slug}', [TvShowController::class, 'showApi'])->name('api.shows.show');
    Route::get('/{slug}/season/{season}', [TvShowController::class, 'seasonApi'])->name('api.shows.season');
});

Route::prefix('reels')->group(function () {
    Route::get('/', [ReelController::class, 'indexApi'])->name('api.reels.index');
    Route::get('/{slug}', [ReelController::class, 'showApi'])->name('api.reels.show');
});

Route::prefix('live')->group(function () {
    Route::get('/', [LiveController::class, 'indexApi'])->name('api.live.index');
    Route::get('/{slug}', [LiveController::class, 'showApi'])->name('api.live.show');
});

Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'indexApi'])->name('api.blog.index');
    Route::get('/{slug}', [BlogController::class, 'showApi'])->name('api.blog.show');
});

Route::get('/search', [MovieController::class, 'searchApi'])->name('api.search');

Route::get('/videos/{slug}', [VideoController::class, 'showApi'])->name('api.videos.show');

Route::get('/pages/{slug}', [PageController::class, 'show'])->name('api.pages.show');

// Authenticated APIs (login चाहिन्छ)
Route::middleware('auth:sanctum')->group(function () {
    // Subscription
    Route::get('/subscriptions', [SubscriptionController::class, 'indexApi'])->name('api.subscriptions.index');
    Route::post('/subscriptions/coupon', [SubscriptionController::class, 'applyCouponApi'])->name('api.subscriptions.coupon');

    // Watch progress save (video हेर्दा position save गर्न)
    Route::post('/watch-progress', [WatchProgressController::class, 'update'])
        ->name('api.watch.progress');

    // Optional: User current subscription
    Route::get('/my-subscription', [SubscriptionController::class, 'currentApi'])->name('api.my.subscription');
});

// Rate limiting (abuse रोक्न) - optional तर सिफारिस
Route::middleware('throttle:60,1')->group(function () {
    // सबै public API लाई १ मिनेटमा ६० request limit
    // यदि चाहियो भने यहाँ सबै public route राख्न सकिन्छ
});