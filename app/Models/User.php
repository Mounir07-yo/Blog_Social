<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'location',
        'website',
        'is_private',
        'is_admin',
        'status',
        'blocked_at',
        'block_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_private' => 'boolean',
            'is_admin' => 'boolean',
            'blocked_at' => 'datetime',
        ];
    }

    // Relations sociales
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relations de suivi
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
                    ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
                    ->withTimestamps();
    }

    // Méthodes utilitaires
    public function isFollowedBy($user)
    {
        if (!$user) return false;
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    public function isFollowing($user)
    {
        if (!$user) return false;
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function followersCount()
    {
        return $this->followers()->count();
    }

    public function followingCount()
    {
        return $this->following()->count();
    }

    public function postsCount()
    {
        return $this->posts()->where('is_published', true)->count();
    }

    // Relations pour les signalements
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function reviewedReports()
    {
        return $this->hasMany(Report::class, 'reviewed_by');
    }

    // Relations pour les messages
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Méthodes utilitaires pour l'administration
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isBlocked()
    {
        return $this->status === 'blocked';
    }

    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    public function canPost()
    {
        return $this->isActive();
    }

    public function canComment()
    {
        return $this->isActive();
    }

    public function block($reason = null, $adminId = null)
    {
        $this->update([
            'status' => 'blocked',
            'blocked_at' => now(),
            'block_reason' => $reason,
        ]);
    }

    public function unblock()
    {
        $this->update([
            'status' => 'active',
            'blocked_at' => null,
            'block_reason' => null,
        ]);
    }

    // Méthodes pour les messages
    public function getConversationWith($userId)
    {
        return Message::conversationBetween($this->id, $userId)
                     ->orderBy('created_at', 'asc')
                     ->get();
    }

    public function getUnreadMessagesCount()
    {
        return $this->receivedMessages()->unread()->count();
    }

    public function getRecentConversations($limit = 10)
    {
        return Message::where('sender_id', $this->id)
                     ->orWhere('receiver_id', $this->id)
                     ->with(['sender', 'receiver'])
                     ->orderBy('created_at', 'desc')
                     ->get()
                     ->groupBy(function ($message) {
                         // Grouper par l'autre utilisateur de la conversation
                         return $message->sender_id === $this->id 
                             ? $message->receiver_id 
                             : $message->sender_id;
                     })
                     ->map(function ($messages) {
                         return $messages->first(); // Prendre le message le plus récent
                     })
                     ->take($limit);
    }

    // Méthodes pour formater les dates avec le bon fuseau horaire
    public function getCreatedAtLocalAttribute()
    {
        return $this->created_at->setTimezone(config('app.timezone'));
    }

    public function getUpdatedAtLocalAttribute()
    {
        return $this->updated_at->setTimezone(config('app.timezone'));
    }
}
