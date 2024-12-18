<?php

namespace App\Http\Controllers;


use App\Http\Requests\CheckSigninRequest;
use App\Http\Requests\CheckSignupRequest;
use App\Http\Requests\CheckVerficationCodeRequest;
use App\Http\Controllers\ResponseHelper;
use App\Http\Controllers\UserService as ControllersUserService;
use Illuminate\Http\JsonResponse;

use Throwable;

class AuthController extends Controller
{
    use  ResponseHelper;

    private ControllersUserService  $_userService;

    public function __construct(ControllersUserService $userService)
    {
        $this->_userService = $userService;
    }

    public function register_pendding_user(CheckSignupRequest $request):JsonResponse
    {
        
        $data=[];

        try
        {
            $data = $this->_userService->register_pendding_user($request->validated());
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }


    public function register(CheckVerficationCodeRequest $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_userService->register_user($request->validated());
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    public function login(CheckSigninRequest $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_userService->login($request->validated());
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    public function logout():JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_userService->logout();
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }


}
