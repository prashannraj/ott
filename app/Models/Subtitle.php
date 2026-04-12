<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtitle extends Model
{
    protected $fillable = ['video_id','language_code','label','file_path'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
