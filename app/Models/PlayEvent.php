<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'device_type',   // mobile, tv, web, tablet
        'platform',      // android, ios, web
        'started_at',
        'ended_at',
        'duration_sec',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
