<?php

// app/Http/Controllers/Frontend/BlogController.php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::where('is_published', true)->latest()->paginate(12);
        return view('frontend.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related = BlogPost::where('id', '!=', $post->id)->take(4)->get();
        return view('frontend.blog.show', compact('post', 'related'));
    }
}