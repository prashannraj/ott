<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // 'admin' वा 'user'
        'avatar',
        'provider',
        'provider_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Filament Admin Panel access control
    public function canAccessPanel(Panel $panel): bool
    {
        // केवल 'admin' role भएका user ले मात्र admin panel मा login गर्न पाउने
        return $this->role === 'admin';
    }

    // Default role 'user' बनाउने accessor (नयाँ user बन्दा)
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'user';
            }
        });
    }

    // Relations
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>=', now())
            ->whereHas('plan', function($query) {
                $query->where('slug', '!=', 'basic');
            })
            ->latest('ends_at')
            ->first();
    }

    // New helper to get the effective plan
    public function currentPlan()
    {
        $premiumSub = $this->activeSubscription();
        if ($premiumSub) {
            return $premiumSub->plan;
        }

        // Default to Basic
        return SubscriptionPlan::where('slug', 'basic')->first();
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function watchlist()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function viewHistories()
    {
        return $this->hasMany(ViewHistory::class);
    }

    // Helper method: Is admin?
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Is premium/subscribed to a paid plan?
    public function isPremium(): bool
    {
        $sub = $this->activeSubscription();
        return $sub && $sub->plan->slug === 'premium';
    }
}