<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteOrderProductsJob;
use App\Models\Cart;
use App\Models\Product;
use Auth;

class CartService
{
    public function index():array
    {

        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
        {
            $products_in_cart =Auth::user()->carts()
            ->with('product')
            ->latest()
            ->get()
            ->map(function($cart) {
                $product = $cart->product;
                return [
                    'id'=>$cart->id,
                    'quantity' =>$cart->quantity,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                ];
            });
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

        return ['data' =>$products_in_cart,'message'=>$message,'code'=>$code];

    }

    public function store($request):array
    {
        $product = Product::where('id',$request->product_id)->first();

        if(!is_null($product))
        {
            if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
            {
                $cart = Auth::user()->carts()->create([
                    'product_id' => $product->id,
                    'quantity'=>$request->quantity
                ]);

                DeleteOrderProductsJob::dispatch()->delay(now()->addMinute(10));

                $data =[
                    'id'=>$cart->id,
                    'quantity' =>$cart->quantity,
                    'product'=>$cart->product()->first(),
                ];

                $message = 'Added to cart successfully';
                $code = 201;


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
            if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
            {
                $cart->update([
                    'quantity' => $request->quantity
                ]);

                $data =[
                    'id'=>$cart->id,
                    'quantity' =>$cart->quantity,
                    'product'=>$cart->product()->first(),
                ];

                $message = 'order_product updated successfully';
                $code = 200;
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
            if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
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

