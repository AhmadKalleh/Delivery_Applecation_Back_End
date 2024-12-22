<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckIfExistsOrderId;
use App\Http\Requests\CheckOrderStoreRequest;
use App\Http\Requests\CheckOrderUpdateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseHelper;

    private OrderService $_orderService;

    public function __construct(OrderService $orderService)
    {
        $this->_orderService = $orderService;
    }
    public function index():JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_orderService->index();
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
    public function store(CheckOrderStoreRequest $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_orderService->store($request);
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
    public function show(CheckIfExistsOrderId $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_orderService->show($request);
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
    public function update(CheckOrderUpdateRequest $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_orderService->update($request);
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
    public function destroy(CheckIfExistsOrderId $request)
    {
        $data=[];

        try
        {
            $data = $this->_orderService->destroy($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }
}
