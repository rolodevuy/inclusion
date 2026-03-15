<?php

namespace App\Notifications;

use App\Models\Postulacion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostulacionEstadoCambiado extends Notification
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
        $estado = $this->postulacion->estado;

        $message = (new MailMessage)
            ->subject("Tu postulación fue {$estado} — {$oferta->titulo}")
            ->greeting("Hola {$notifiable->name},");

        if ($estado === 'aceptada') {
            $message->line("¡Buenas noticias! Tu postulación al puesto **{$oferta->titulo}** fue aceptada.")
                    ->line('La empresa revisó tu perfil y quiere avanzar con vos.');
        } elseif ($estado === 'rechazada') {
            $message->line("Tu postulación al puesto **{$oferta->titulo}** no fue seleccionada en esta oportunidad.")
                    ->line('Te animamos a seguir explorando otras ofertas.');
        } else {
            $message->line("El estado de tu postulación al puesto **{$oferta->titulo}** cambió a: **{$estado}**.");
        }

        return $message
            ->action('Ver mis postulaciones', url('/candidato/postulaciones'))
            ->salutation('Inclusión Laboral');
    }
}
