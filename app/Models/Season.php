<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Season extends Model
{
    protected $fillable = ['tv_show_id','season_number','title'];

    public function tvShow()
    {
        return $this->belongsTo(TvShow::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}
