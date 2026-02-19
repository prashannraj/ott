<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','slug','description','type','release_date',
        'age_rating','duration_sec','poster_path','thumbnail_path',
        'banner_path','seo_title','seo_description','seo_keywords'
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    // Relations
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
        return $this->belongsToMany(Genre::class, 'genre_video');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_video');
    }

    public function files()
    {
        return $this->hasMany(VideoFile::class);
    }

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function viewHistories()
    {
        return $this->hasMany(ViewHistory::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Accessors (image URLs)
    public function getPosterUrlAttribute()
    {
        return $this->poster_path ? Storage::url($this->poster_path) : asset('images/placeholder-poster.jpg');
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner_path ? Storage::url($this->banner_path) : asset('images/default-hero.jpg');
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : asset('images/placeholder-thumbnail.jpg');
    }

    public function getBestStreamUrlAttribute()
    {
        return $this->files()
            ->where('format', 'hls')
            ->orderByRaw("FIELD(quality, '1080p', '720p', '480p', '360p')")
            ->first()?->path
            ?? $this->files()->first()?->path;
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }
}