<?php

namespace App\Notifications;

use App\Models\Report;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportNotification extends Notification
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
            'type' => 'report',
            'reporter_id' => $this->reporter->id,
            'reporter_name' => $this->reporter->name,
            'report_id' => $this->report->id,
            'reason' => $this->report->reason,
            'description' => $this->report->description,
            'content_type' => $contentType,
            'content_title' => $contentTitle,
            'content_author_id' => $this->reportedContent->user_id,
            'content_author_name' => $this->reportedContent->user->name ?? 'Utilisateur inconnu',
            'message' => "Nouveau signalement : {$this->reporter->name} a signalé un {$contentType} pour \"{$this->report->reason}\"",
            'url' => route('admin.reports.show', $this->report->id)
        ];
    }
}