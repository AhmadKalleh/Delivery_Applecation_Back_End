<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class CancelOrder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    private $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' =>'order_deleted',
            'title' =>'Existing Order Canceled',
            'description' => 'The Order Number is '.$this->order->id.' cancelled successfully',
            'created_at' => Carbon::parse( $this->order->created_at)->format('d/m/Y'),
            'deleted_at' =>Carbon::now()->format('d/m/Y'),

        ];
    }
}
