<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteFavoriteHistoryJob;
use App\Models\Product;
use Auth;

class FavoriteService
{
    public function index():array
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
        {
            $favorites = Auth::user()->favorites()
            ->latest()
            ->get()
            ->map(function($favorite)
            {
                $product = $favorite->product;
                return [
                    'id' =>$favorite->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                ];
            });
        }

        if($favorites->isEmpty())
        {
            $message = 'there are no products to display';
        }
        else
        {
            $message = 'products_in_favorite returned successfully';
        }

        $code = 200;

        return ['data' =>$favorites,'message'=>$message,'code'=>$code];

    }

    public function store($request):array
    {
        $product = Product::where('id',$request->product_id)->first();

        if(!is_null($product))
        {
            if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
            {
                $favorite = Auth::user()->favorites()->create([
                    'product_id' => $request->product_id
                ]);

                DeleteFavoriteHistoryJob::dispatch()->delay(now()->addMinute(10));

                $data =[
                    'id'=>$favorite->id,
                    'product'=>$favorite->product()->first(),
                ];

                $message = 'Added To favorite successfully';
                $code = 200;
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

    public function destroy($request):array
    {
        $favorite = Auth::user()->favorites()->where('id',$request->favorite_id)->first();

        if(!is_null($favorite))
        {
            if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
            {
                Auth::user()->favorites()->where('id',$request->favorite_id)->delete();
                $data=[];
                $message = 'favorite deleted successfully';
                $code = 200;
            }

        }
        else
        {
            $data=[];
            $message = 'favorite not found';
            $code = 404;
        }

        return ['data' =>$data,'message'=>$message,'code'=>$code];
    }



}
