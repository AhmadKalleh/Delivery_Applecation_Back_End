<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckUpdateImageProfileRequest;
use App\Http\Requests\CheckUpdatePasswordRequest;
use App\Http\Requests\CheckUpdatePhoneNumberRequest;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ResponseHelper;
    private UserService  $_userService;

    public function __construct(UserService $userService)
    {
        $this->_userService = $userService;

    }

    /**
     * Display the specified resource.
     */
    public function show():JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_userService->show_info();
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
    public function update_user_phone_number(CheckUpdatePhoneNumberRequest $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_userService->update_user_phone_number($request->validated());
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    public function update_image_profile(CheckUpdateImageProfileRequest $request):JsonResponse
    {
        $data=[];
        try
        {
            $data = $this->_userService->update_user_image_profile($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }

    public function check_password(CheckUpdatePasswordRequest $request):JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_userService->check_user_password($request->validated());
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }

    }


    public function update_user_password(CheckUpdatePasswordRequest $request):JsonResponse
    {
        $data=[];
        try
        {
            $data = $this->_userService->update_user_password($request->validated());
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
            $data = $this->_userService->delete_user($request);
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }
}


