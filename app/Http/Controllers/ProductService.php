<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Store;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    use ResponseHelper;
    use UplodeImageHelper;



public function index($request)
{
    // تحديد اللغة بناءً على رأس الطلب
    //$language = $request->header('Accept-Language', 'en');
    App::setLocale('ar');

    $store = Store::query()->where('id', '=', $request)->first();

    if (!is_null($store)) {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client')) {
            $products = $store->products()
                ->get()
                ->map(function ($product) {
                    $image_path = $product->images->first()->image_path ?? null;
                    $name = $product->getTranslation('name', App::getLocale());
                    $description = $product->getTranslation('description', App::getLocale());
                    return [
                        'id' => $product->id,
                        'name' => $name,
                        'description' => $description,
                        'price' => $product->formatted_price,
                        'quantity' => $product->quantity,
                        'image_url' => $image_path ? Storage::url($image_path) : null
                    ];
                });
        }

        if ($products->isEmpty()) {
            $message = 'no_products_available';
        } else {
            $message = 'messages.products_retrieved_successfully';
        }

        $code = 200;
        return ['data' => ['products' => $products], 'message' => $message, 'code' => $code];
    } else {
        $message = 'messages.store_not_found';
        $code = 404;
        return ['data' => $store, 'message' => $message, 'code' => $code];
    }
}


    public function Serach($request)
    {
        $store = Store::query()->where('id', '=', $request->store_id)->first();

        if(!is_null($store))
        {
            if(Auth::user()->hasRole('admin') ||  Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
            {
                $products = $store->products()
                ->where('products.name', 'LIKE','%'.$request->value.'%' )
                ->get()
                ->map(function ($product) {
                    $image_path = $product->images->first()->image_path ?? null;
                    return [
                        'id'=>$product->id,
                        'name'=>$product->name,
                        'description'=>$product->description,
                        'price'=>$product->formatted_price,
                        'quantity'=>$product->quantity,
                        'image_url'=>$image_path ? Storage::url($image_path) : null
                    ];
                });
            }

                if($products->isEmpty())
                {
                    $message = 'There are no products available for this store.';
                }
                else
                {
                    $message = 'Products retrieved successfully';
                }

                $code = 200;
                return ['data' =>['products' => $products],'message'=>$message,'code'=>$code];
        }
        else
        {
            $message = 'Store not found';
            $code = 404;
            return ['data' =>$store,'message'=>$message,'code'=>$code];
        }
    }

    public function store($request):array
    {

        $store = Store::query()->where('id', '=', $request['store_id'])->first();

        if(!is_null($store))
        {
            if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin'))
            {
                $product = $store->products()->create([
                    'name'=>$request['name'],
                    'description'=>$request['description'],
                    'price'=>$request['price'],
                    'quantity'=>$request['quantity'],
                    'store_id' =>$request['store_id'],
                ]);

                $images = [];

                foreach ($request->file('images') as $key => $imageFile)
                {
                    $imagePath = $this->uplodeImage($imageFile, 'products');
                    $isPrimary = $key === 0;
                    Image::create
                    ([
                        'image_path' => $imagePath,
                        'is_primary' => $isPrimary,
                        'product_id' => $product->id,
                    ]);

                    $images[] = [
                        'image_url' => Storage::url($imagePath),
                        'is_primary' => $isPrimary,
                    ];
                }

            $message = 'Product created successfully';
            $code = 201;

            $data = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->formatted_price,
                'quantity' => $product->quantity,
                'images' => $images,
            ];

                return ['data' =>$data,'message'=>$message,'code'=>$code];
            }
        }
        else
        {
            $message = 'Store not found';
            $code = 404;
            return ['data' =>$store,'message'=>$message,'code'=>$code];
        }


    }

    public function show(Request $request)
    {
        $product = Product::query()->where('id', '=', $request->product_id)->first();
        if(!is_null($product))
        {
            if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
            {
                $data = [
                    'id' => $product->id,
                    'name'=>$product->name,
                    'description' => $product->description,
                    'price' => $product->formatted_price,
                    'quantity' => $product->quantity,
                    'images' =>$product->images()
                    ->orderBy('is_primary','desc')
                    ->get()
                    ->map(function($image){
                        $image_url = Storage::url($image->image_path);
                        return $image_url;
                    })
                ];

                $message = 'Product has been retrived successfully';
                $code = 200;
                return ['data' =>$data,'message'=>$message,'code'=>$code];
            }
        }
        else
        {
            $message = 'Product not found';
            $code = 404;
            return ['data' =>$product,'message'=>$message,'code'=>$code];
        }
    }

    public function update($request):array
    {
        $product = Product::query()->where('id', '=', $request['product_id'])->first();
        if (!is_null($product))
        {

            $store = $product->store()->first();

            if (!is_null($store) && ((Auth::user()->hasRole('admin') && $store->user_id == Auth::id()) || Auth::user()->hasRole('superAdmin')))
            {
                $image_path = $product->images()
                    ->where('is_primary', 1)
                    ->pluck('image_path')
                    ->first();

                $product->update([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'price' => $request['price'],
                    'quantity' => $request['quantity'],
                ]);

                if (Storage::exists($image_path)) {
                    Storage::delete($image_path);
                }

                $product->images()
                    ->where('is_primary', 1)
                    ->update([
                        'image_path' => $this->uplodeImage($request->file('images')[0], 'products'),
                    ]);

                $data = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->formatted_price,
                    'quantity' => $product->quantity,
                    'image_url' => Storage::url($product->images()->where('is_primary', 1)->pluck('image_path')->first()),
                ];

                $message = 'Product updated successfully';
                $code = 200;
            }
            else
            {
                $message = 'You do not have the required authorization';
                $code = 403;
                $data = [];
            }

            return ['data' => $data, 'message' => $message, 'code' => $code];
        }
        else
        {
            $message = 'Product not found';
            $code = 404;
            return ['data' => $product, 'message' => $message, 'code' => $code];
        }

    }

    public function destroy(Request $request):array
    {
        $product = Product::where('id', $request->product_id)->first();

        if (!is_null($product))
        {
            $store = $product->store()->first();

            if (!is_null($store) && ((Auth::user()->hasRole('admin') && $store->user_id == Auth::id()) || Auth::user()->hasRole('superAdmin'))) {
                // حذف الصور المرتبطة بالمنتج
                $product->images()
                    ->get()
                    ->map(function ($image) {
                        if (Storage::exists($image->image_path)) {
                            Storage::delete($image->image_path);
                        }
                    });

                // حذف المنتج
                $product->delete();

                $data = [];
                $message = 'Product deleted successfully';
                $code = 200;
            }
            else
            {
                $message = 'You do not have the required authorization';
                $code = 403;
                $data = [];
            }
        }
        else
        {
            $message = 'Product not found';
            $code = 404;
            $data = [];
        }

        return ['data' => $data, 'message' => $message, 'code' => $code];

    }


}
