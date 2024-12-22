<?php

namespace App\Notifications;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliveredOrder extends Notification
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
            'type' =>'order_delivered',
            'title' =>'Existing order delivered',
            'description' => 'Your order delivered successfully.The Order Number is '.$this->order->id,
            'status' => 'Delivered',
            'created_at' => Carbon::parse( $this->order->created_at)->format('d/m/Y'),
            'delivered_at' => Carbon::now()->format('d/m/Y'),
            'order_items_that_you_ordered' => $this->order->orderProducts->map(function($item){
                return [
                    'order_item_name' =>$item->product->name.' and in quantity : '.$item->quantity
                ];
            }),
            'total_price' =>$this->order->total_price
        ];
    }
}
