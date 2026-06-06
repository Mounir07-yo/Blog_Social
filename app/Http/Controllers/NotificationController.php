<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
                             ->notifications()
                             ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()
                            ->notifications()
                            ->where('id', $id)
                            ->first();

        if ($notification) {
            $notification->markAsRead();
            
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }
            
            // Rediriger vers l'URL de la notification si elle existe
            if (isset($notification->data['url'])) {
                return redirect($notification->data['url']);
            }
        }

        return redirect()->route('notifications.index');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('notifications.index')
                        ->with('success', 'Toutes les notifications ont été marquées comme lues');
    }

    public function unreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();
        
        return response()->json(['count' => $count]);
    }

    public function getLatest()
    {
        $notifications = Auth::user()
                             ->unreadNotifications()
                             ->limit(5)
                             ->get();

        return response()->json($notifications);
    }
}