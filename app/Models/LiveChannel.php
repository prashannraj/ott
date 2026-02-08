<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use app\Models\LiveStream;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LiveChannel extends Model
{
    //
    protected $fillable = [
        'name','slug','logo_path','category_id','language','is_premium'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function streams()
    {
        return $this->hasMany(LiveStream::class);
    }

    public function activeStream()
    {
        return $this->streams()->where('is_active', true)->latest()->first();
    }
}
