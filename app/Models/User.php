<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Profile;
use App\Models\Subscription;
use App\Models\Rental;
use App\Models\Watchlist;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
   use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role','avatar'];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profiles()
    {
        return $this->hasMany(Profile::class);
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
            ->latest('ends_at');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function watchlist()
    {
        return $this->hasMany(Watchlist::class);
    }
}
