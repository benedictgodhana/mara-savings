<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SavingsAccountCreated extends Notification
{
    use Queueable;

    public function __construct() {}

    public function via($notifiable)
    {
        return ['mail']; // You can also add 'database' or 'sms' if needed
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Savings Account Has Been Created')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your savings account has been successfully created.')
            ->line('You can now log in to view and manage your account.')
            ->action('Login to Your Account', url('/login'))
            ->line('Thank you for using our service!');
    }
}
