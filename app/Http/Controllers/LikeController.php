<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Notifications\PostLikedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function togglePost(Post $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $post->likes()->create(['user_id' => Auth::id()]);
            $isLiked = true;
            
            // Envoyer une notification si ce n'est pas l'auteur qui like son propre article
            if ($post->user_id !== Auth::id()) {
                $post->user->notify(new PostLikedNotification(Auth::user(), $post));
            }
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'isLiked' => $isLiked,
                'likesCount' => $post->likesCount(),
            ]);
        }

        return back();
    }

    public function toggleComment(Comment $comment)
    {
        $like = $comment->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $comment->likes()->create(['user_id' => Auth::id()]);
            $isLiked = true;
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'isLiked' => $isLiked,
                'likesCount' => $comment->likesCount(),
            ]);
        }

        return back();
    }
}