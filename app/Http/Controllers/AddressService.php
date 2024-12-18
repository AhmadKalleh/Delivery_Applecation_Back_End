<?php

namespace App\Http\Controllers;

use Auth;

class AddressService
{

    public function index():array
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
        {
            $addresses = Auth::user()->addresses()
            ->latest()
            ->get()
            ->map(function($address){
                return [
                    'id' =>$address->id,
                    'name' =>$address->name,
                    'country' =>$address->country,
                    'city' =>$address->city,
                    'area'=>$address->area,
                    'street'=>$address->street,
                ];
            });
        }

        if($addresses->isEmpty())
        {
            $message = 'There are no addresses to display';
        }
        else
        {
            $message = 'addressses returned successfully';
        }

        $code = 200;
        return ['data' =>$addresses,'message'=>$message,'code'=>$code];
    }

    public function store($request):array
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
        {
            $address = Auth::user()->addresses()->create([
                'name' =>$request->name,
                'country' => $request->country,
                'city' => $request->city,
                'area' => $request->area,
                'street' =>$request->street
            ]);

            $data = [
                'id'=> $address -> id,
                'name' =>$address->name,
                'country' => $address->country,
                'city'=>$address->city,
                'area' => $address->area,
                'street' => $address->street
            ];

            $message = 'address added successfully';
            $code = 200;
            return ['data' =>$data,'message'=>$message,'code'=>$code];
        }
    }

    public function destroy($request):array
    {
        $address = Auth::user()->addresses()->where('id',$request->address_id)->first();

        if(!is_null($address))
        {
            Auth::user()->addresses()->where('id',$request->address_id)->delete();
            $data = [];
            $message = 'address deleted successfully';
            $code = 200;
        }
        else
        {
            $data = [];
            $message = 'address not found';
            $code = 404;
        }

        return ['data' =>$data,'message'=>$message,'code'=>$code];
    }
}
