<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::where('is_published', 1)
            ->latest()
            ->paginate(9);

        return view('frontend.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_published', 1)
            ->firstOrFail();

        $relatedPosts = BlogPost::where('is_published', 1)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts'));
    }

    // API: Get paginated list of published blog posts
    public function indexApi(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $posts = BlogPost::where('is_published', 1)
            ->latest()
            ->paginate($perPage);

        $data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt ?? substr(strip_tags($post->content), 0, 150) . '...',
                'image' => $post->banner_image ? asset('storage/' . $post->banner_image) : null,
                'published_at' => $post->published_at ? $post->published_at->format('Y-m-d') : null,
                'author' => 'Admin',  // ← author relation हटाइयो, hardcode गरियो
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ]
        ]);
    }

    // API: Get single blog post details by slug
    public function showApi($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_published', 1)
            ->firstOrFail();

        $relatedPosts = BlogPost::where('is_published', 1)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($rel) {
                return [
                    'id' => $rel->id,
                    'title' => $rel->title,
                    'slug' => $rel->slug,
                    'excerpt' => substr(strip_tags($rel->content), 0, 100) . '...',
                    'image' => $rel->banner_image ? asset('storage/' . $rel->banner_image) : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'post' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content' => $post->content,
                    'excerpt' => $post->excerpt ?? substr(strip_tags($post->content), 0, 150) . '...',
                    'image' => $post->banner_image ? asset('storage/' . $post->banner_image) : null,
                    'published_at' => $post->published_at ? $post->published_at->format('Y-m-d') : null,
                    'author' => 'Admin',  // ← author relation हटाइयो, hardcode गरियो
                ],
                'related_posts' => $relatedPosts,
            ]
        ]);
    }
}