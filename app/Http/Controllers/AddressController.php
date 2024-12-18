<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class AddressController extends Controller
{

    use ResponseHelper;
    private AddressService  $_addressService;

    public function __construct(AddressService  $addressService)
    {
        $this->_addressService = $addressService;
    }

    public function index() : JsonResponse
    {
        $data=[];
        try
        {
            $data = $this->_addressService->index();
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }


    }

    public function store(Request $request): JsonResponse
    {
        $data=[];
        try
        {
            $data = $this->_addressService->store($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    public function destroy(Request $request):JsonResponse
    {
        $data=[];
        try
        {
            $data = $this->_addressService->destroy($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }
    public function show(string $id)
    {
        //

    }

    public function update(Request $request, string $id)
    {
        //
    }


}
