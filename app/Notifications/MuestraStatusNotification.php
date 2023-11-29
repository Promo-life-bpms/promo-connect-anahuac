<?php

namespace App\Notifications;

use App\Models\Muestra;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MuestraStatusNotification extends Notification
{
    use Queueable;

    protected $muestra;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Muestra $muestra)
    {
        $this->muestra = $muestra;
        // dd($this->muestra->product);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
        // ->subject('Actualización de estado de muestra')
        // ->line('El estado de la muestra ha sido actualizado.')
        // ->line('Nuevo estado: ' . $this->muestra->status);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->muestra->id,
            'user_id' => $this->muestra->user_id,
            'status' => $this->muestra->status,
            'product_id' => $this->muestra->product_id,
            'product_name' => ucwords($this->muestra->product->name),
            'created_at' => $this->muestra->created_at,
        ];
    }
}
