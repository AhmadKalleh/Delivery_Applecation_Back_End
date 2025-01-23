<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteFavoriteHistoryJob;
use App\Models\Favorite;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\Storage;

class FavoriteService
{
    public function index():array
    {
        if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
        {
            $favorites = Auth::user()->favorites()
            ->latest()
            ->get()
            ->map(function($favorite)
            {
                $product = $favorite->product;
                return [
                    'id' =>$favorite->id,
                    'product_id' =>$product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->formatted_price,
                    'store_name' => $product->store->name,
                    'image_url' => Storage::url($product->images->first()->image_path),
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

        return ['data' =>['favorites' =>  $favorites ],'message'=>$message,'code'=>$code];

    }
    public function store($request):array
    {
        $product = Product::where('id',$request->product_id)->first();

        if(!is_null($product))
        {
            if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
            {

                if(Favorite::query()->where('product_id',$product->id)->first())
                {
                    $data = [];
                    $message = 'this product is already in the favorites';
                    $code = 410;
                    return ['data' =>$data,'message'=>$message,'code'=>$code];
                }
                else
                {
                    $favorite = Auth::user()->favorites()->create([
                        'product_id' => $request->product_id
                    ]);

                    DeleteFavoriteHistoryJob::dispatch()->delay(now()->addMinute(10));

                    $data =[
                        'id'=>$favorite->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                    ];

                    $message = 'Added To favorite successfully';
                    $code = 200;
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

    public function destroy($request):array
    {
        $favorite = Auth::user()->favorites()->where('id',$request->favorite_id)->first();

        if(!is_null($favorite))
        {
            if (Auth::user()->hasAnyRole(['admin', 'superAdmin', 'client']))
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
