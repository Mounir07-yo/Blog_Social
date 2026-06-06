<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Post;

class PostLikedNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'post_liked',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'message' => $this->user->name . ' a aimé votre article "' . $this->post->title . '"',
            'url' => route('posts.show', $this->post),
        ];
    }
}