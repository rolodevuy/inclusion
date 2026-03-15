<?php

namespace App\Notifications;

use App\Models\Postulacion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoPostulante extends Notification
{
    use Queueable;

    public function __construct(
        public Postulacion $postulacion,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $oferta = $this->postulacion->oferta;
        $candidato = $this->postulacion->candidato;

        return (new MailMessage)
            ->subject("Nueva postulación: {$oferta->titulo}")
            ->greeting("Hola {$notifiable->name},")
            ->line("**{$candidato->name}** se postuló a tu oferta **{$oferta->titulo}**.")
            ->when($this->postulacion->mensaje, function ($message) {
                $message->line("Mensaje: \"{$this->postulacion->mensaje}\"");
            })
            ->action('Ver postulantes', url("/empresa/ofertas/{$oferta->id}"))
            ->salutation('Inclusión Laboral');
    }
}
