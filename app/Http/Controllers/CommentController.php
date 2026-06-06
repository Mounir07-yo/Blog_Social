<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        // Envoyer une notification si ce n'est pas l'auteur qui commente son propre article
        if ($post->user_id !== Auth::id()) {
            $post->user->notify(new CommentNotification(Auth::user(), $post, $comment));
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user', 'replies'),
                'message' => 'Commentaire ajouté avec succès !'
            ]);
        }

        return back()->with('success', 'Commentaire ajouté avec succès !');
    }

    public function update(Request $request, Comment $comment)
    {
        // Vérifier que l'utilisateur est l'auteur
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Commentaire mis à jour !'
            ]);
        }

        return back()->with('success', 'Commentaire mis à jour !');
    }

    public function destroy(Comment $comment)
    {
        // Vérifier que l'utilisateur est l'auteur
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Commentaire supprimé !'
            ]);
        }

        return back()->with('success', 'Commentaire supprimé !');
    }
}