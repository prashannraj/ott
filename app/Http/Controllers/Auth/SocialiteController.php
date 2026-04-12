<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver($provider);
        return $driver->stateless()->redirect();
    }

    public function callback($provider)
    {
        try {
            /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
            $driver = Socialite::driver($provider);
            $socialUser = $driver->stateless()->user();

            $user = User::where('provider_id', $socialUser->getId())
                        ->where('provider', $provider)
                        ->first();

            if (!$user) {
                $user = User::where('email', $socialUser->getEmail())->first();

                if ($user) {
                    $user->update([
                        'provider_id' => $socialUser->getId(),
                        'provider' => $provider,
                        'avatar' => $socialUser->getAvatar(),
                    ]);
                } else {
                    $user = User::create([
                        'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                        'email' => $socialUser->getEmail(),
                        'provider_id' => $socialUser->getId(),
                        'provider' => $provider,
                        'avatar' => $socialUser->getAvatar(),
                        'password' => Hash::make(uniqid()), // Set a random password
                    ]);
                }
            }

            // Create token for API authentication
            $token = $user->createToken('social-login-' . time())->plainTextToken;

            // Redirect to Next.js frontend with the token
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            return redirect($frontendUrl . '/auth/callback?token=' . $token);
        } catch (\Exception $e) {
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            return redirect($frontendUrl . '/login?error=social_login_failed');
        }
    }
}
