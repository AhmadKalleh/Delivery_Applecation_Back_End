<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteOrderProductsJob;
use App\Models\Cart;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\Storage;

class CartService
{
    public function index():array
    {

        if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
        {
            $products_in_cart =Auth::user()->carts()
            ->with('product')
            ->latest()
            ->get()
            ->map(function($cart) {
                $product = $cart->product;
                if($product->quantity > 0)
                {
                    return [
                        'id'=>$cart->id,
                        'quantity' =>$cart->quantity,
                        'max_quantity' =>$product->quantity,
                        'store_name' =>$product->store->name,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->formatted_price,
                        'image_url' => Storage::url($product->images->first()->image_path),
                    ];
                }
            })->filter()->values();
        }

        if($products_in_cart->isEmpty())
        {
            $message = 'Cart is empty';
        }
        else
        {
            $message = 'products_in_cart returned successfully';
        }

        $code = 200;

        return ['data' =>['products_in_carts' => $products_in_cart ],'message'=>$message,'code'=>$code];

    }


    public function store($request):array
    {
        $product = Product::where('id',$request->product_id)->first();

        if(!is_null($product))
        {
            if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
            {
                if($request->quantity <= $product->quantity)
                {

                    if (!Auth::user()->carts()->where('product_id', $product->id)->exists())
                    {
                        $cart = Auth::user()->carts()->create([
                            'product_id' => $product->id,
                            'quantity'=>$request->quantity
                        ]);

                    }
                    else
                    {
                        $cart = Auth::user()->carts()->where('product_id', $product->id)->first();
                        $cart->update([
                            'quantity' => $cart->quantity + $request->quantity,
                        ]);

                    }

                    DeleteOrderProductsJob::dispatch()->delay(now()->addMinute(10));

                    $data =[
                        'id'=>$cart->id,
                        'quantity' =>$cart->quantity,
                        'product_id'=>$cart->product->id,
                        'product_name' =>$cart->product->name,
                        'product_price' =>$cart->product->formatted_price.' SYP'
                    ];

                    $message = 'Added to cart successfully';
                    $code = 201;
                }
                else
                {
                    $data=[];
                    $message = 'Not enough quantity in stock';
                    $code = 400;
                }

            }
        }
        else
        {
            $data=[];
            $message = 'Product not found';
            $code = 404;
        }

        return ['data' =>$data,'message'=>$message,'code'=>$code];
    }

    public function update($request):array
    {
        $cart = Cart::where('id',$request->cart_id)->first();

        if(!is_null($cart))
        {
            if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
            {
                if($request->quantity == 0)
                {
                    $cart->delete();
                    $data = [];
                    $message = 'order_product deleted successfully';
                    $code = 410;
                }
                else if($request->quantity <= $cart->product->quantity)
                {
                    $cart->update([
                        'quantity' => $request->quantity
                    ]);

                    $data =[
                        'id'=>$cart->id,
                        'quantity' =>$cart->quantity,
                        'product_id'=>$cart->product->id,
                        'product_name' =>$cart->product->name,
                        'product_price' =>$cart->product->formatted_price.' SYP'
                    ];

                    $message = 'order_product updated successfully';
                    $code = 200;
                }
                else
                {
                    $data=[];
                    $message = 'Quantity exceeds stock';
                    $code = 400;
                }
            }

        }
        else
        {
            $data=[];
            $message = 'Cart not found';
            $code = 404;
        }

        return ['data' =>$data,'message'=>$message,'code'=>$code];
    }

    public function destroy($request):array
    {
        $cart = Cart::where('id',$request->cart_id)->first();

        if(!is_null($cart))
        {
            if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
            {
                Auth::user()->carts()
                ->where('id',$request->cart_id)->delete();

                $data=[];
                $message = 'order_product deleted successfully';
                $code =200;
            }

        }
        else
        {
            $data=[];
            $message = 'Cart not found';
            $code = 404;

        }

        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }
}

