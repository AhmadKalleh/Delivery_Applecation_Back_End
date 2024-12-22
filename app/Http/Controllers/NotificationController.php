<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Throwable;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ResponseHelper;

    private NotificationService $_notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->_notificationService = $notificationService;
    }

    public function index():JsonResponse
    {
        $data=[];

        try
        {
            $data = $this->_notificationService->index();
            return $this->Success($data['data'],$data['message'],$data['code']);
        }
        catch(Throwable $e)
        {
            $message = $e->getMessage();
            return $this->Error($data,$message);
        }
    }
}
