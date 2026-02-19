<?php

use Illuminate\Support\Facades\Route;

// routes/web.php (पूर्ण routes - demo जस्तै UI को लागि)
use App\Http\Controllers\Frontend\MovieController;
use App\Http\Controllers\Frontend\TvShowController;
use App\Http\Controllers\Frontend\ReelController;
use App\Http\Controllers\Frontend\LiveController;
use App\Http\Controllers\Frontend\SubscriptionController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\VideoController;

Route::get('/', [MovieController::class, 'home'])->name('home');

Route::group(['prefix' => 'movies'], function () {
    Route::get('/', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/{slug}', [MovieController::class, 'show'])->name('movies.show');
    Route::get('/category/{category}', [MovieController::class, 'category'])->name('movies.category');
});

Route::group(['prefix' => 'shows'], function () {
    Route::get('/', [TvShowController::class, 'index'])->name('shows.index');
    Route::get('/{slug}', [TvShowController::class, 'show'])->name('shows.show');
    Route::get('/{slug}/season/{season}', [TvShowController::class, 'season'])->name('shows.season');
});

Route::group(['prefix' => 'reels'], function () {
    Route::get('/', [ReelController::class, 'index'])->name('reels.index');
    Route::get('/{slug}', [ReelController::class, 'show'])->name('reels.show');
});

Route::group(['prefix' => 'live'], function () {
    Route::get('/', [LiveController::class, 'index'])->name('live.index');
    Route::get('/{slug}', [LiveController::class, 'show'])->name('live.show');
});

Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
Route::post('/subscriptions/coupon', [SubscriptionController::class, 'applyCoupon'])->name('subscriptions.coupon');

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');
});

Route::get('/search', [MovieController::class, 'search'])->name('search');

Route::get('/videos/{slug}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/watch/{slug}', [VideoController::class, 'watch'])->name('watch');

// Auth routes (Breeze वा Jetstream प्रयोग गरेर थप्नुहोस् यदि चाहियो भने)
Route::get('/login', function () { return view('auth.login'); })->name('login');