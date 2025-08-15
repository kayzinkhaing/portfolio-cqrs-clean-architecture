<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of blogs (public).
     * Use a scoped query to filter by user_id if provided.
     */
    public function index(Request $request)
    {
        // Use a local scope to optionally filter by user_id
        $blogs = Blog::query()
            ->when($request->filled('user_id'), function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })
            ->with('user:id,name')
            ->latest()
            ->cursorPaginate(10);

        return response()->json($blogs);
    }

    /**
     * Display a listing of blogs for a specific user.
     * This method is optimized for a large number of users.
     */
    public function userBlogs(User $user)
    {
        // Directly query the Blog model and filter by the user_id.
        $blogs = Blog::where('user_id', $user->id)
            ->latest()
            ->cursorPaginate(10);

        return response()->json($blogs);
    }

    /**
     * Store a newly created blog (authenticated users only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

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
        $this->authorize('update', $blog);

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

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
        $this->authorize('delete', $blog);

        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully.',
        ]);
    }
}
