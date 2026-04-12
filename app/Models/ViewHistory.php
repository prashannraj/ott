<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Video;


class ViewHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'last_position_sec',
        'completed',
        'last_watched_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'last_watched_at' => 'datetime',
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
