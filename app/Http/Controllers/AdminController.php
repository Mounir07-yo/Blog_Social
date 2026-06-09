<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'blocked_users' => User::where('status', 'blocked')->count(),
            'total_posts' => Post::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
        ];

        $recent_reports = Report::with(['user', 'reportable'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_reports'));
    }

    public function users(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');

        $users = User::query()
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->withCount(['posts', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.index', compact('users', 'status', 'search'));
    }

    public function blockUser(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $user->block($request->reason, Auth::id());

        return back()->with('success', "L'utilisateur {$user->name} a été bloqué.");
    }

    public function unblockUser(User $user)
    {
        $user->unblock();

        return back()->with('success', "L'utilisateur {$user->name} a été débloqué.");
    }

    public function deleteUser(User $user)
    {
        // Empêcher la suppression du propre compte admin
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "L'utilisateur {$name} a été supprimé définitivement.");
    }

    public function deletePost(Post $post)
    {
        $title = $post->title;
        $post->delete();

        return back()->with('success', "L'article '{$title}' a été supprimé.");
    }

    public function posts(Request $request)
    {
        $search = $request->get('search');
        $user_id = $request->get('user_id');

        $posts = Post::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($user_id, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.posts.index', compact('posts', 'search', 'user_id'));
    }
}
