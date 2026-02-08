<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Reel;
use App\Models\Genre;
use App\Models\Category;
use App\Models\VideoFile;
use App\Models\Subtitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Video extends Model
{
     protected $fillable = [
        'title','slug','description','type','release_date',
        'age_rating','duration_sec','poster_path','thumbnail_path',
        'banner_path','seo_title','seo_description','seo_keywords'
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function movie()
    {
        return $this->hasOne(Movie::class);
    }

    public function episode()
    {
        return $this->hasOne(Episode::class);
    }

    public function reel()
    {
        return $this->hasOne(Reel::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function files()
    {
        return $this->hasMany(VideoFile::class);
    }

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class);
    }

        public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}
