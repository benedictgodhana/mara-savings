<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegisteredNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Registration Successful')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for registering with us.')
            ->line('Your registration was successful, and we are currently reviewing your account.')
            ->line('You will receive another email once your account is approved and ready to use.')
            ->line('Thank you for your patience!');
    }
}
