<?php

namespace App\Notifications;

use App\Models\SolicitudAcceso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudAccesoRecibida extends Notification
{
    use Queueable;

    public function __construct(
        public SolicitudAcceso $solicitud,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $empresa = $this->solicitud->empresa;
        $nombreEmpresa = $empresa->empresaProfile->nombre_empresa ?? $empresa->name;

        $message = (new MailMessage)
            ->subject("Solicitud de acceso de {$nombreEmpresa}")
            ->greeting("Hola {$notifiable->name},")
            ->line("La empresa **{$nombreEmpresa}** solicita acceder a tu información de accesibilidad.");

        if ($this->solicitud->mensaje) {
            $message->line("Mensaje: \"{$this->solicitud->mensaje}\"");
        }

        return $message
            ->line('Podés aprobar o rechazar esta solicitud desde tu panel.')
            ->action('Ver solicitudes', url('/candidato/solicitudes'))
            ->salutation('Inclusión Laboral');
    }
}
