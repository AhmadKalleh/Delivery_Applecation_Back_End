<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckStoreRequest;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class StoreController extends Controller
{
    use  ResponseHelper;

    private StoreService  $_storeService;

    public function __construct(StoreService $_storeService)
    {
        $this->_storeService = $_storeService;
    }
    /**
     * Display a listing of the resource.
     */


    public function index():JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_storeService->index();
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
    public function store(CheckStoreRequest $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_storeService->store($request);
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
    public function show(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CheckStoreRequest $request):JsonResponse
    {

        $data=[];
        try
        {
            $data = $this->_storeService->update($request);
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
            $data = $this->_storeService->destroy($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }
}
