<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketEstadoActualizado extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;
    public $estadoAnterior;
    public $estadoNuevo;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket, $estadoAnterior, $estadoNuevo)
    {
        $this->ticket = $ticket;
        $this->estadoAnterior = $estadoAnterior;
        $this->estadoNuevo = $estadoNuevo;
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
        $estadoEmoji = match($this->estadoNuevo) {
            'abierto' => '🔴',
            'en_proceso' => '🟡',
            'cerrado' => '🟢',
            default => '📋'
        };

        return (new MailMessage)
            ->subject($estadoEmoji . ' Actualización Ticket #' . $this->ticket->id)
            ->greeting('¡Hola ' . $this->ticket->nombre . '!')
            ->line('Tu ticket ha sido actualizado.')
            ->line('**Ticket ID:** #' . $this->ticket->id)
            ->line('**Cambio de Estado:** ' . ucfirst($this->estado_anterior) . ' → ' . ucfirst($this->estado_nuevo))
            ->line('**Título:** ' . $this->ticket->titulo)
            ->action('Ver Estado del Ticket', url('/estado/' . $this->ticket->token_acceso))
            ->line('Puedes verificar el estado en cualquier momento usando el enlace anterior.')
            ->salutation('Gracias por tu paciencia.\\n**Equipo HelpDesk**');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_title' => $this->ticket->titulo,
            'estado_anterior' => $this->estadoAnterior,
            'estado_nuevo' => $this->estadoNuevo,
            'type' => 'ticket_estado_actualizado',
        ];
    }
}
