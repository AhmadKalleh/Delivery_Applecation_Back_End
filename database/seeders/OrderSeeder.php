<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Jobs\UpdateOrderStatusJob;
use App\Notifications\CreateOrder;
use Illuminate\Support\Facades\Notification;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $address = Address::query()->create([
            'name' =>'My home',
            'country' => 'Syria',
            'city' => 'rIF-dAMAS',
            'area' => 'qRAR',
            'street' =>'DD',
            'user_id' =>6
        ]);

        $cart1 = Cart::query()->create([
            'user_id' => 6,
            'product_id' => 10,
            'quantity'=>20
        ]);

        $cart2 = Cart::query()->create([
            'user_id' => 6,
            'product_id' => 11,
            'quantity'=>20
        ]);

        $order = Order::query()->create([
            'user_id' => 6,
            'address_id' =>$address->id,
            'total_price' => 43000000,
            'payment_method' => 'CASH',
            'delivery_date' => Carbon::now()->addMinutes(10),
        ]);

        $order->orderProducts()->create([
            'product_id' => $cart1->product_id,
            'quantity' => $cart1->quantity,
            'price' => $cart1->product->price,
            'total_price' => $cart1->product->price * $cart1->quantity,
        ]);

        $cart1->product->decrement('quantity', $cart1->quantity);

        $order->orderProducts()->create([
            'product_id' => $cart2->product_id,
            'quantity' => $cart2->quantity,
            'price' => $cart2->product->price,
            'total_price' => $cart2->product->price * $cart2->quantity,
        ]);

        $cart2->product->decrement('quantity', $cart2->quantity);

        User::query()->where('id','=',6)->first()->carts()->delete();

        UpdateOrderStatusJob::dispatch($order)->delay(now()->addMinutes(10));
        Notification::send($order->user,new CreateOrder($order));
    }
}
