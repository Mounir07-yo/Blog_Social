<?php

namespace App\Notifications;

use App\Models\Report;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserReportedNotification extends Notification
{
    use Queueable;

    protected $report;
    protected $reporter;
    protected $reportedContent;

    public function __construct(Report $report, User $reporter, $reportedContent)
    {
        $this->report = $report;
        $this->reporter = $reporter;
        $this->reportedContent = $reportedContent;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $contentType = $this->report->reportable_type === 'App\Models\Post' ? 'article' : 'commentaire';
        $contentTitle = '';
        
        if ($this->report->reportable_type === 'App\Models\Post') {
            $contentTitle = $this->reportedContent->title ?? 'Article sans titre';
        } else {
            $contentTitle = substr($this->reportedContent->content ?? 'Commentaire', 0, 50) . '...';
        }

        return [
            'type' => 'user_reported',
            'reporter_name' => $this->reporter->name,
            'report_id' => $this->report->id,
            'reason' => $this->report->reason,
            'content_type' => $contentType,
            'content_title' => $contentTitle,
            'message' => "Votre {$contentType} \"{$contentTitle}\" a été signalé pour : {$this->report->reason}",
            'url' => $this->report->reportable_type === 'App\Models\Post' 
                ? route('posts.show', $this->reportedContent->slug)
                : route('posts.show', $this->reportedContent->post->slug) . '#comment-' . $this->reportedContent->id,
            'created_at' => now()
        ];
    }
}