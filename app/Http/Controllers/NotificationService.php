<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Carbon;

class NotificationService
{
    public function index():array
    {
        if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
        {
            $notifications = Auth::user()->notifications()
            ->latest()
            ->get()
            ->map(function ($notification)
            {
                if($notification->data['type'] == 'order_created' || $notification->data['type'] == 'order_updated')
                {
                    return [
                        'title' => $notification->data['title'],
                        'description' => $notification->data['description'],
                        'status' => $notification->data['status'],
                        'total_price' => number_format($notification->data['total_price'],0,'.',','),
                        'created_at' => $notification->data['created_at'],
                        'order_items_that_you_ordered' => $notification->data['order_items_that_you_ordered'],
                    ];
                }
                else if($notification->data['type'] == 'order_deleted')
                {
                    return [
                        'title' => $notification->data['title'],
                        'description' => $notification->data['description'],
                        'created_at' => $notification->data['created_at'],
                        'deleted_at' => $notification->data['deleted_at'],
                    ];
                }
                else if($notification->data['type'] == 'order_delivered')
                {
                    return [
                        'title' => $notification->data['title'],
                        'description' => $notification->data['description'],
                        'created_at' => $notification->data['created_at'],
                        'delivered_at' =>$notification->data['delivered_at'],
                        'status' => $notification->data['status'],
                        'total_price' => number_format($notification->data['total_price'],0,'.',','),
                        'order_items_that_you_ordered' => $notification->data['order_items_that_you_ordered'],
                    ];
                }
            });

            if($notifications->count() > 0)
            {
                $message = 'notifications returned successfully';
                $code = 200;
                return ['data' =>['notifications' => $notifications] ,'message' => $message,'code' => $code];
            }
            else
            {
                $message = 'No notifications available';
                $code = 200;
                return ['data' => [],'message' => $message,'code' => $code];
            }
        }
    }
}
