<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Throwable;


class FavoriteController extends Controller
{
    use ResponseHelper;

    private FavoriteService $_favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->_favoriteService = $favoriteService;
    }

    public function index():JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_favoriteService->index();
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
            $data = $this->_favoriteService->store($request);
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
            $data = $this->_favoriteService->destroy($request);
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
