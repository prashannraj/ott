<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WatchProgressController; // यो controller पछि बनाउँछौं

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication required routes
Route::middleware('auth:sanctum')->group(function () {
    // Watch progress save API
    Route::post('/watch-progress', [WatchProgressController::class, 'update'])
        ->name('api.watch.progress');
});

// Optional: Test route (auth बिना पनि हेर्न मिलोस् भनेर)
Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});