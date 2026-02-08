<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Video;

class Category extends Model
{
    protected $fillable = ['name','slug','type'];

    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }
}
