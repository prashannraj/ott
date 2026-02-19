<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'banner_image',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // अगाडि जाँदा यदि categories/tag चाहियो भने यहाँ relationships थप्न सकिन्छ।
}
