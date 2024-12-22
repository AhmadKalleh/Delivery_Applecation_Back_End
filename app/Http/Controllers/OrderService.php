<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateOrderStatusJob;
use App\Models\Cart;
use App\Models\Order;
use App\Notifications\CancelOrder;
use App\Notifications\CreateOrder;
use App\Notifications\UpdateOrder;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;


class OrderService
{


    public function index():array
    {
        if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
        {
            $completedOrders = Auth::user()->orders()
            ->where('status', 'Delivered')
            ->latest()
            ->get()
            ->map(function ($order){
                return [
                    'id' => $order->id,
                    'total_price' => $order->formatted_price,
                ];
            });

            $pendingOrders = Auth::user()->orders()
            ->where('status', 'Pending')
            ->latest()
            ->get()
            ->map(function ($order){
                return [
                    'id' => $order->id,
                    'total_price' => $order->formatted_price,
                ];
            });

            if($pendingOrders->count() >0 || $completedOrders->count() > 0)
            {
                $message = 'Orders have been retrieved successfully';
                $code = 200;
                return ['data' => ['orders' => ['completed' => $completedOrders,'penddings' => $pendingOrders] ],'message' => $message,'code' => $code];
            }
            else
            {
                $message = 'No orders available';
                $code = 200;
                return ['data' => [],'message' => $message,'code' => $code];
            }
        }
    }

    public function store($request):array
    {
        if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
        {
            $order = Order::query()->create([
                'user_id' => Auth::id(),
                'address_id' =>$request['address_id'],
                'total_price' => $request['total_price'],
                'payment_method' => $request['payment_method'],
                'delivery_date' => Carbon::now()->addMinutes(10),
            ]);

            $cartItems = Cart::query()->where('user_id', Auth::user()->id)->get();

            foreach ($cartItems as $cartItem)
            {
                $order->orderProducts()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    'total_price' => $cartItem->product->price * $cartItem->quantity,
                ]);

                $cartItem->product->decrement('quantity', $cartItem->quantity);
            }

            Auth::user()->carts()->delete();

            UpdateOrderStatusJob::dispatch($order)->delay(now()->addMinutes(10));
            Notification::send($order->user,new CreateOrder($order));

            $data =[
                'id' =>$order->id,
                'total_price' =>$order->formatted_price,
            ];

            $message = 'Order added successfully';
            $code = 201;

            return ['data' => $data,'message' => $message,'code' => $code];
        }

    }

    public function show($request):array
    {
        if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
        {
            $order = Auth::user()->orders()->where('id', $request['order_id'])->first();

            if (!is_null($order))
            {
                $data = $order->orderProducts()
                    ->latest()
                    ->get()
                    ->map(function ($orderProduct){
                        return [
                            'id' => $orderProduct->id,
                            'quantity' => $orderProduct->quantity,
                            'price' => $orderProduct->product->formatted_price,
                            'total_price' => $orderProduct->formatted_price,
                            'product_id' =>$orderProduct->product->id,
                            'product_name' => $orderProduct->product->name,
                            'product_description' => $orderProduct->product->description,
                        ];
                    });


                $message = 'Order has been retrieved successfully';
                $code = 200;


            }
            else
            {
                $data=[];
                $message = 'Order not found';
                $code = 404;
            }

            return ['data' => $data,'message' => $message,'code' => $code];

        }

    }

    public function update($request):array
    {

        if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
        {
            $order = Auth::user()->orders()->where('id','=',$request['order_id'])->first();

            $total_price = 0;

        foreach($request['orderProducts'] as $orderProduct)
        {
            $existingOrderProduct  = $order->orderProducts()->where('id','=',$orderProduct['id'])->first();

            if($orderProduct['quantity'] == 0)
            {
                $existingOrderProduct->product->increment('quantity',$existingOrderProduct->quantity);
                $existingOrderProduct->delete();
            }

            else if($existingOrderProduct->quantity >= $orderProduct['quantity'])
            {
                $existingOrderProduct->product->increment('quantity',$existingOrderProduct->quantity - $orderProduct['quantity']);

                $existingOrderProduct->update([
                    'quantity' =>$orderProduct['quantity'],
                    'price'=> $existingOrderProduct->product->price,
                    'total_price' => $orderProduct['quantity'] * $existingOrderProduct->product->price,
                ]);

                $total_price+=$existingOrderProduct->total_price;
            }
            else if($existingOrderProduct->quantity < $orderProduct['quantity'])
            {
                $existingOrderProduct->product->decrement('quantity',$orderProduct['quantity'] -$existingOrderProduct->quantity );

                $existingOrderProduct->update([
                    'quantity' =>$orderProduct['quantity'],
                    'price'=> $existingOrderProduct->product->price,
                    'total_price' => $orderProduct['quantity'] * $existingOrderProduct->product->price
                ]);

                $total_price+=$existingOrderProduct->total_price;
            }

        }

            $order->update([
                'total_price' => $total_price
            ]);

            Notification::send($order->user,new UpdateOrder($order));
            $data = $order->orderProducts()
                ->latest()
                ->get()
                ->map(function ($orderProduct){
                    return [
                            'id' => $orderProduct->id,
                            'quantity' => $orderProduct->quantity,
                            'price' => $orderProduct->product->formatted_price,
                            'total_price' => $orderProduct->formatted_price,
                            'product_id' =>$orderProduct->product->id,
                            'product_name' => $orderProduct->product->name,
                            'product_description' => $orderProduct->product->description,
                    ];
            });

            $message = 'Order Updated successfully';
            $code = 200;

            return ['data' => $data,'message' => $message,'code' => $code];
        }
    }

    public function destroy($request):array
    {
        if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
        {
            $order = Auth::user()->orders()->where('id','=',$request['order_id'])->first();

            $order->orderProducts()
            ->get()
            ->map(function ($orderProduct)
            {
                $orderProduct->product()->increment('quantity',$orderProduct->quantity);
            });

            Notification::send($order->user,new CancelOrder($order));
            $order->delete();

            $data=[];
            $message = 'Order deleted successfully';
            $code = 200;

            return ['data' => $data,'message' => $message,'code' => $code];
        }
    }
}
