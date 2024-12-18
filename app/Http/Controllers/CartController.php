<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Throwable;

class CartController extends Controller
{

    use ResponseHelper;
    private CartService  $_cartService;

    public function __construct(CartService $cartService)
    {
        $this->_cartService = $cartService;
    }


    public function index():JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_cartService->index();
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    public function store(Request $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_cartService->store($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    public function update(Request $request):JsonResponse
    {
        $data=[];


        try
        {
            $data = $this->_cartService->update($request);
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
            $data = $this->_cartService->destroy($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }
}
