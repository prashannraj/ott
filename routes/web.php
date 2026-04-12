<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// routes/web.php (पूर्ण routes - demo जस्तै UI को लागि)
use App\Http\Controllers\Frontend\MovieController;
use App\Http\Controllers\Frontend\TvShowController;
use App\Http\Controllers\Frontend\ReelController;
use App\Http\Controllers\Frontend\LiveController;
use App\Http\Controllers\Frontend\SubscriptionController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\VideoController;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Auth\SocialiteController;

Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

require __DIR__.'/auth.php';
