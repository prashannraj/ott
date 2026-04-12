<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $locale = $request->query('locale', 'en');

        $page = Page::where('slug', $slug)
            ->where('locale', $locale)
            ->where('is_active', true)
            ->first();

        // If requested locale not found, fallback to English
        if (!$page && $locale !== 'en') {
            $page = Page::where('slug', $slug)
                ->where('locale', 'en')
                ->where('is_active', true)
                ->first();
        }

        if (!$page) {
            return response()->json([
                'status' => 'error',
                'message' => 'Page not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $page,
        ]);
    }
}
