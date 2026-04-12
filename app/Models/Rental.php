<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Video;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    //
     protected $fillable = ['user_id','video_id','order_id','expires_at'];

    protected $dates = ['expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isActive(): bool
    {
        return $this->expires_at->isFuture();
    }
}
