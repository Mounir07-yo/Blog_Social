<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()
                     ->published()
                     ->latest()
                     ->with(['user', 'likes', 'comments'])
                     ->paginate(10);

        return view('users.show', compact('user', 'posts'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'avatar' => 'nullable|url|max:255',
            'is_private' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user)
                        ->with('success', 'Profil mis à jour avec succès !');
    }

    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(20);
        return view('users.followers', compact('user', 'followers'));
    }

    public function following(User $user)
    {
        $following = $user->following()->paginate(20);
        return view('users.following', compact('user', 'following'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return view('users.search', ['users' => collect(), 'query' => '']);
        }

        $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->limit(20)
                    ->get();

        return view('users.search', compact('users', 'query'));
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'confirmation' => 'required|in:DELETE',
        ]);

        $user = Auth::user();

        // Vérifier le mot de passe
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mot de passe incorrect.']);
        }

        // Empêcher la suppression d'un compte admin (sécurité)
        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Les comptes administrateurs ne peuvent pas être supprimés via cette interface.']);
        }

        $userName = $user->name;

        // Déconnexion et suppression
        Auth::logout();
        $user->delete();

        return redirect()->route('welcome')
                        ->with('success', "Compte de {$userName} supprimé avec succès.");
    }
}