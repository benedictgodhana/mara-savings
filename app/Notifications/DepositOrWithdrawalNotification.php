<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DepositOrWithdrawalNotification extends Notification
{
    use Queueable;

    public $amount;
    public $type;
    public $referenceNumber;

    // Constructor to pass relevant data
    public function __construct($amount, $type, $referenceNumber)
    {
        $this->amount = $amount;
        $this->type = $type;
        $this->referenceNumber = $referenceNumber;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Transaction Notification')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('Your recent transaction was ' . $this->type . ' of KES ' . number_format($this->amount, 2))
                    ->line('Reference Number: ' . $this->referenceNumber)
                    ->line('Thank you for using our service!')
                    ->action('View Account', url('/savings-account'));
    }

    public function toArray($notifiable)
    {
        return [
            'amount' => $this->amount,
            'type' => $this->type,
            'reference_number' => $this->referenceNumber,
        ];
    }
}
