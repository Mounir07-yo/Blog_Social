<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of published posts.
     */
    public function index()
    {
        $posts = Post::published()
                    ->latest()
                    ->with(['user', 'likes', 'comments'])
                    ->paginate(10);

        return view('blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|max:500',
            'content' => 'required',
            'featured_image' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'post_type' => 'in:article,photo,status',
            'is_published' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['post_type'] = $validated['post_type'] ?? 'article';
        
        if ($validated['is_published'] ?? false) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        return redirect()->route('posts.show', $post)
                        ->with('success', 'Article créé avec succès !');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        // Si l'article n'est pas publié et que l'utilisateur n'est pas l'auteur
        if (!$post->is_published && (!Auth::check() || Auth::id() !== $post->user_id)) {
            abort(404);
        }

        $post->load(['user', 'comments.user', 'comments.replies.user', 'likes']);
        
        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        // Vérifier que l'utilisateur est l'auteur
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        return view('blog.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Vérifier que l'utilisateur est l'auteur
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|max:500',
            'content' => 'required',
            'featured_image' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'post_type' => 'in:article,photo,status',
            'is_published' => 'boolean',
        ]);

        if ($validated['is_published'] ?? false && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)
                        ->with('success', 'Article mis à jour avec succès !');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        // Vérifier que l'utilisateur est l'auteur
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', 'Article supprimé avec succès !');
    }
}