<?php

namespace App\Notifications;

use App\Models\Conversacion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoMensaje extends Notification
{
    use Queueable;

    public function __construct(
        public Conversacion $conversacion,
        public User $remitente,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Nuevo mensaje de {$this->remitente->name}")
            ->greeting("Hola {$notifiable->name},")
            ->line("**{$this->remitente->name}** te envió un mensaje en la conversación: \"{$this->conversacion->asunto}\".")
            ->action('Ver conversación', url("/mensajes/{$this->conversacion->id}"))
            ->salutation('Inclusión Laboral');
    }
}
