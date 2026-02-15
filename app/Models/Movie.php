<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    protected $fillable = ['video_id','is_premium','allow_download'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
