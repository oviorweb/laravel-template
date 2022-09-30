<?php

declare(strict_types=1);

namespace Domain\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LockedOut extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting(__('Hello :name,', $notifiable->name))
            ->subject(__('Your account has been locked'))
            ->line(__("We've detected suspicious activity on your Invercio account and have temporarily locked it as a security precaution for 1 minute."));
    }
}
