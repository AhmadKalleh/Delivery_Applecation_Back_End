<?php

namespace App\Http\Controllers;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
