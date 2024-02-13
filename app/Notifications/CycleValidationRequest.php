<?php

namespace App\Notifications;

use App\Models\Cycle;
use App\Models\Study;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CycleValidationRequest extends Notification
{
    use Queueable;
    protected $cycle;
    protected $studentName;

    /**
     * Create a new notification instance.
     */
    public function __construct(Study $study, $studentName)
    {
        $this->study = $study;
        $this->studentName = $studentName;
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
        $dateMessage = $this->study->date ? 'En la fecha: ' . $this->study->date : 'Aún lo está cursando';
        return (new MailMessage)
            ->line('Por favor, verifica que el alumno: ' . $this->studentName)
            ->line('Ha cursado el ciclo: ' . $this->study->cycle->cliteral)
            ->line($dateMessage)
            ->action('Verificar', url('/api/verificated/'. $this->study->id));
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
