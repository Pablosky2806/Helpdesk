<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCerrado extends Notification implements ShouldQueue
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
     * Get the email address to send the notification to.
     */
    public function routeNotificationFor(object $notifiable)
    {
        // Usar el email del formulario del ticket, no el del usuario de la cuenta
        return $this->ticket->email;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Ticket #' . $this->ticket->id . ' Resuelto')
            ->greeting('¡Hola ' . $this->ticket->nombre . '!')
            ->line('¡Buenas noticias! Tu ticket ha sido resuelto y cerrado.')
            ->line('**Resumen de tu ticket:**')
            ->line('**Ticket ID:** #' . $this->ticket->id)
            ->line('**Asunto:** ' . $this->ticket->titulo)
            ->line('**Categoría:** ' . ucfirst(str_replace('_', ' ', $this->ticket->categoria)))
            ->line('**Tiempo de resolución:** ' . $this->ticket->tiempo_resolucion)
            ->line('Si el problema persiste o tienes alguna duda, no dudes en contactarnos.')
            ->action('Ver Ticket Cerrado', route('tickets.show', $this->ticket->id))
            ->line('¡Gracias por tu paciencia!')
            ->salutation('**Equipo HelpDesk**');
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
            'type' => 'ticket_cerrado',
        ];
    }
}
