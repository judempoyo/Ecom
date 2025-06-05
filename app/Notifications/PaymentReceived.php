<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
    // app/Notifications/PaymentReceived.php
public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Confirmation de paiement')
        ->line("Votre paiement de {$this->payment->amount} $ a été reçu.")
        ->action('Voir la commande', route('orders.show', $this->order))
        ->line('Merci pour votre achat!');
}

public function toTwilio($notifiable)
{
    return (new TwilioSmsMessage)
        ->content("Paiement confirmé! Commande #{$this->order->id}");
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
