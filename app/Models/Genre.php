<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    protected $fillable = ['name','slug'];

    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }
}
