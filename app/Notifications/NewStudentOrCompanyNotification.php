<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStudentOrCompanyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($student, $studies=null)
    {
        $this->student = $student;
        $this->studies = $studies;
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
    public function toMail($notifiable)
    {
        $ciclos = '';
        foreach ($this->studies as $study) {
            $ciclos .= $study->cycle->cliteral . ', ';
        }

        if (!empty($ciclos)) {
            $ciclos = rtrim($ciclos, ', ');
        } else {
            $ciclos = 'Ningún ciclo';
        }
        return (new MailMessage)
            ->subject('Activación de cuenta')
            ->line('¡Bienvenido! Una vez completado el registro, comprueba tus datos y activa tu cuenta.')
            ->line('Nombre: ' . $this->student->user->name . $this->student->user->surname)
            ->line('Ciclos: ' . $ciclos)
            ->action('Activar cuenta', url('/api/active/'.$this->student->id));
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
