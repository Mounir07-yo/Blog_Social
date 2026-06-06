<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $post;
    protected $comment;

    public function __construct(User $user, Post $post, Comment $comment)
    {
        $this->user = $user;
        $this->post = $post;
        $this->comment = $comment;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_comment',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'message' => $this->user->name . ' a commenté votre article "' . $this->post->title . '"',
            'url' => route('posts.show', $this->post) . '#comment-' . $this->comment->id,
        ];
    }
}