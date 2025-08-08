<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of blogs (public).
     */
    public function index()
    {
        // Eager load user (author) with only id and name fields
        $blogs = Blog::with('user:id,name')->latest()->get();

        return response()->json($blogs);
    }

    /**
     * Store a newly created blog (authenticated users only).
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        // Create blog post for logged-in user
        $blog = Blog::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'published_at' => $request->published_at,
        ]);

        return response()->json([
            'message' => 'Blog created successfully.',
            'blog' => $blog,
        ], 201);
    }

    /**
     * Display the specified blog (public).
     */
    public function show(Blog $blog)
    {
        $blog->load('user:id,name');
        return response()->json($blog);
    }

    /**
     * Update the specified blog (only if owned by user).
     */
    public function update(Request $request, Blog $blog)
    {
        // Check authorization policy: only owner can update
        $this->authorize('update', $blog);

        // Validate input
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        // Update blog
        $blog->update($request->only(['title', 'excerpt', 'content', 'published_at']));

        return response()->json([
            'message' => 'Blog updated successfully.',
            'blog' => $blog,
        ]);
    }

    /**
     * Remove the specified blog (only if owned by user).
     */
    public function destroy(Blog $blog)
    {
        // Check authorization policy: only owner can delete
        $this->authorize('delete', $blog);

        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully.',
        ]);
    }
}
