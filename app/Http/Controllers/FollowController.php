<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        if (Auth::id() === $user->id) {
            return response()->json([
                'error' => 'Vous ne pouvez pas vous suivre vous-même !'
            ], 400);
        }

        $isFollowing = Auth::user()->isFollowing($user);

        if ($isFollowing) {
            Auth::user()->following()->detach($user->id);
            $message = 'Vous ne suivez plus ' . $user->name;
        } else {
            Auth::user()->following()->attach($user->id);
            $message = 'Vous suivez maintenant ' . $user->name;
            
            // Envoyer une notification
            $user->notify(new NewFollowerNotification(Auth::user()));
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'isFollowing' => !$isFollowing,
                'followersCount' => $user->followersCount(),
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
}