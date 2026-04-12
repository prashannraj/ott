<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoFile extends Model
{
     protected $fillable = ['video_id','quality','format','path','size_bytes'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
