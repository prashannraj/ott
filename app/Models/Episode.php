<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Season;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    protected $fillable = ['season_id','video_id','episode_number','name'];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
    public function getDisplayTitleAttribute()
    {
        return $this->name ?? "Episode {$this->episode_number}";
    }
}
