<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('frontend.user.dashboard', [
            'user' => $user,
            'profile' => $user->profile,
            'activeSubscription' => $user->activeSubscription(),
            'rentals' => $user->rentals()->latest()->take(5)->get(),
            'watchlist' => $user->watchlist()->latest()->take(10)->get(),
            'viewHistories' => $user->viewHistories()->with('video')->latest()->take(10)->get(),
        ]);
    }
}