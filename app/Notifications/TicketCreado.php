<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreado extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
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
        return (new MailMessage)
            ->subject('🎫 Nuevo Ticket Creado - #' . $this->ticket->id)
            ->greeting('¡Hola ' . $this->ticket->nombre . '!')
            ->line('Hemos recibido tu solicitud de soporte técnico.')
            ->line('Aquí están los detalles de tu ticket:')
            ->line('**Ticket ID:** #' . $this->ticket->id)
            ->line('**Asunto:** ' . $this->ticket->titulo)
            ->line('**Categoría:** ' . ucfirst(str_replace('_', ' ', $this->ticket->categoria)))
            ->line('**Prioridad:** ' . ucfirst($this->ticket->prioridad))
            ->line('**Estado:** ' . ucfirst(str_replace('_', ' ', $this->ticket->estado)))
            ->action('Ver Estado del Ticket', url('/estado/' . $this->ticket->token_acceso))
            ->line('Puedes verificar el estado en cualquier momento usando el enlace anterior.')
            ->line('Nos pondremos en contacto contigo pronto.')
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
            'type' => 'ticket_creado',
        ];
    }
}
