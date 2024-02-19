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
    public function __construct($user, $studies=null)
    {
        $this->user = $user;
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

        if ($this->user->rol == 'STU'){
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
                ->line('¡Bienvenido/a! Una vez completado el registro, comprueba tus datos y activa tu cuenta.')
                ->line('Nombre: ' . $this->user->name . $this->user->surname)
                ->line('Ciclos: ' . $ciclos)
                ->action('Activar cuenta', url('/api/active/'.$this->user->id));
        } else {
            return (new MailMessage)
                ->subject('Activación de cuenta')
                ->line('¡Bienvenido/a! Una vez completado el registro, comprueba tus datos y activa tu cuenta.')
                ->line('Nombre: ' . $this->user->name . $this->user->surname)
                ->action('Activar cuenta', url('/api/active/'.$this->user->id));
        }

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
