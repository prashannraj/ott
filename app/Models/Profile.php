<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'avatar',
        'age_rating_limit',
        'is_kid',
    ];

    protected $casts = [
        'is_kid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
