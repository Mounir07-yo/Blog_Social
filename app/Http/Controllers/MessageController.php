<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()->getRecentConversations();
        $unreadCount = Auth::user()->getUnreadMessagesCount();
        
        return view('messages.index', compact('conversations', 'unreadCount'));
    }

    public function show(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('messages.index')->with('error', 'Vous ne pouvez pas vous envoyer de message à vous-même.');
        }

        $messages = Auth::user()->getConversationWith($user->id);
        
        // Marquer les messages reçus comme lus
        Message::where('sender_id', $user->id)
               ->where('receiver_id', Auth::id())
               ->where('is_read', false)
               ->update([
                   'is_read' => true,
                   'read_at' => now()
               ]);

        return view('messages.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000',
            ]);

            if ($user->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas vous envoyer de message à vous-même.'
                ], 422);
            }

            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id,
                'content' => $request->content,
            ]);

            $message->load('sender');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => [
                        'id' => $message->id,
                        'content' => $message->content,
                        'sender_name' => $message->sender->name,
                        'sender_id' => $message->sender->id,
                        'created_at' => $message->created_at->setTimezone('Europe/Paris')->format('H:i'),
                        'created_at_full' => $message->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i'),
                    ]
                ]);
            }

            return back()->with('success', 'Message envoyé avec succès.');
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi du message: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'envoi du message: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Erreur lors de l\'envoi du message.');
        }
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->getUnreadMessagesCount();
        
        return response()->json([
            'count' => $count
        ]);
    }
}