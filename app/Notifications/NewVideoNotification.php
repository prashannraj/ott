<?php

namespace App\Notifications;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVideoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $video;

    /**
     * Create a new notification instance.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('movies.show', $this->video->slug);

        return (new MailMessage)
            ->subject('New Content Uploaded: ' . $this->video->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new ' . $this->video->type . ' has been uploaded to ' . config('app.name') . '.')
            ->line('Title: ' . $this->video->title)
            ->action('Watch Now', $url)
            ->line('Enjoy the new content!')
            ->line('Thank you for being a part of Madhesh Films!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
