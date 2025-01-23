<?php

namespace App\Http\Controllers;

use App\Models\Store;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class StoreService
{
    use UplodeImageHelper;
    public function index():array
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
        {
            $stores = Store::query()
                ->orderBy('created_at','desc')
                ->get()
                ->map(function ($store) {
                return [
                    'id' =>$store->id,
                    'name' =>$store->name,
                    'description' =>$store->description,
                    'image_url' =>$store->image_path ? Storage::url($store->image_path) : null,
                    'products'=>$store->products->map(function($product){
                        return [
                            'id'=>$product->id,
                            'name'=>$product->name,
                            'description'=>$product->description,
                            'price'=>$product->formatted_price,
                            'quantity'=>$product->quantity,
                            'image_url'=> $product->images->first()->image_path ? Storage::url($product->images->first()->image_path) : null,
                        ];
                    })
                ];
        });

        }


        if($stores->isEmpty())
        {
            $message = 'There are no stores available';
        }
        else
        {
            $message = 'Stores have been retrieved successfully';
        }


        $code = 200;
        return ['data' =>['stores' => $stores ],'message'=>$message,'code'=>$code];

    }


    public function store($request):array
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin'))
        {
            $store = Auth::user()->stores()->create([
                'name' => $request['name'],
                'image_path' =>$this->uplodeImage($request->file('image_path'),'stores'),
                'description' =>$request['description'],
            ]);

            $message = 'Store has been created successfully';
            $code=201;

            $data = [
                'id'=>$store->id,
                'name' =>$store->name,
                'description'=>$store->description,
                'image_url' =>Storage::url($store->image_path)
            ];


            return ['data' => $data,'message' => $message, 'code' => $code];
        }
    }

    public function update($request):array
    {

        $store = Store::query()->where('id','=',$request['id'])->first();

        if(!is_null($store))
        {
            if(Auth::user()->hasRole('admin') && ($store->user_id== Auth::id())|| Auth::user()->hasRole('superAdmin'))
            {
                $image_path = $store->image_path;
                $store->update([
                    'name' => $request['name'],
                    'image_path' => $this->uplodeImage($request['image_path'],'stores'),
                    'description' => $request['description'],
                ]);

                if(Storage::exists($image_path))
                {
                    Storage::delete($image_path);
                }

                $data = [
                    'id'=>$store->id,
                    'name' =>$store->name,
                    'description'=>$store->description,
                    'image_url' =>Storage::url($store->image_path)
                ];

                $message = 'store updated successfully';
                $code = 200;


            }
            else
            {
                $message = 'You do not have the required authorization';
                $code = 403;
                $data=[];
            }

            return ['data' => $data,'message' => $message, 'code' => $code];
        }
        else
        {
            $data=[];
            $message = 'This Store Not found';
            $code=404;
        }

        return ['data' => $data,'message' => $message, 'code' => $code];

    }

    public function destroy(Request $request):array
    {
        $store = Store::query()->where('id','=',$request->id)->first();

        if(!is_null($store))
        {
            if(Auth::user()->hasRole('admin') && ($store->user_id== Auth::id())|| Auth::user()->hasRole('superAdmin'))
            {
                $image_path = $store->image_path;

                if(Storage::exists($image_path))
                {
                    Storage::delete($image_path);
                }

                $store->products()->get()->map(function ($product) {
                    $product->images()->get()->map(function ($image) {
                        if (Storage::exists($image->image_path)) {
                            Storage::delete($image->image_path);
                        }
                    });
                });

                $store->delete();

                $data=[];
                $message = 'Store deleted successfully';
                $code = 200;
            }
            else
            {
                $message = 'You do not have the required authorization';
                $code = 403;
                $data=[];
            }

            return ['data' => $data,'message' => $message, 'code' => $code];
        }
        else
        {
            $data=[];
            $message = 'This Store Not found';
            $code=404;
        }

        return ['data' => $data,'message' => $message, 'code' => $code];
    }

}

