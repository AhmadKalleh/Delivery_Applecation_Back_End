<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckStoreProduct2Request;
use App\Http\Requests\CheckStoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProductController extends Controller
{


    use ResponseHelper;
    private ProductService  $_productService;

    public function __construct(ProductService  $productService)
    {
        $this->_productService = $productService;
    }
    public function index(Request $request):JsonResponse
    {
        $data=[];
        try
        {
            $data = $this->_productService->index($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckStoreProductRequest $request):JsonResponse
    {
        $data=[];
        try
        {
            $data = $this->_productService->store($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_productService->show($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CheckStoreProductRequest $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_productService->update($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_productService->destroy($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }
}
