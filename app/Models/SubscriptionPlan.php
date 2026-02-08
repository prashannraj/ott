<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name','slug','price','currency','duration_days',
        'max_devices','quality','description','is_active',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}

