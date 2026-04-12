<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Season;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TvShow extends Model
{
    protected $fillable = [
        'title','slug','description','poster_path','banner_path',
        'age_rating','total_seasons','seo_title','seo_description','seo_keywords'
    ];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function episodes()
    {
        return Episode::whereIn('season_id', $this->seasons->pluck('id'))->get();
    }
}
