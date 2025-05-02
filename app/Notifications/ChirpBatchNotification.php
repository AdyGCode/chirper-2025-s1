<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ChirpBatchNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Collection $chirps)
    {
        Log::info('Creating new batch notification', ['chirp_count' => $chirps->count()]);
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
        Log::info('Preparing email for batch notification', [
            'user_id' => $notifiable->id ?? 'unknown',
            'chirp_count' => $this->chirps->count()
        ]);

        $mailMessage = (new MailMessage)
            ->subject('New Chirps Digest')
            ->greeting('Here\'s your chirps digest')
            ->line('You have ' . $this->chirps->count() . ' new chirps to check out:');

        // Add each chirp with its author to the email
        foreach ($this->chirps as $chirp) {
            if (isset($chirp->user) && isset($chirp->user->name)) {
                $mailMessage->line("- {$chirp->user->name}: {$chirp->message}");
            } else {
                $mailMessage->line("- Unknown user: {$chirp->message}");
            }
        }

        return $mailMessage
            ->action('Go to Chirper', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'chirp_count' => $this->chirps->count(),
            'chirp_ids' => $this->chirps->pluck('id')->toArray(),
        ];
    }
}
