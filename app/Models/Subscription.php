<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Subscription extends Model
{
    //
    protected $fillable = [
        'user_id','subscription_plan_id','starts_at','ends_at',
        'status','payment_gateway','payment_reference'
    ];

    protected $dates = ['starts_at','ends_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->ends_at->isFuture();
    }
}
