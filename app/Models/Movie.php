<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Video;

class Movie extends Model
{
    protected $fillable = ['video_id','is_premium','allow_download'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
