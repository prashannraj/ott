<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reel extends Model
{
    protected $fillable = ['video_id','is_vertical','max_length_sec'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
