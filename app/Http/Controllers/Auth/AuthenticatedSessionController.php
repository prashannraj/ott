<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Handle an incoming API authentication request (mobile app login)
     * URL: POST /api/login
     * Body: { "email": "...", "password": "..." }
     */
    public function storeApi(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials. Please check your email and password.'
            ], 401);
        }

        // Get authenticated user
        $user = Auth::user();

        // Create Sanctum token
        $token = $user->createToken('mobile-app-' . time())->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Destroy an API session (logout)
     * URL: POST /api/logout
     * Method: POST
     * Requires: auth:sanctum
     */
    public function destroyApi(Request $request)
    {
        // Logout via Sanctum
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
}
