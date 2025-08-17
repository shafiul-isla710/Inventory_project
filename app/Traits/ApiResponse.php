<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ApiResponse
{
     public function responseWithSuccess($status = true, $message='Success',$data=[],$code=200):JsonResponse
   {
        return response()->json([
           'status' => $status,
           'message' => $message,
           'data' => $data,
        ], $code);
   }
    public function responseWithError($status = false, $message='Failed',$errors=[],$code=400):JsonResponse
   {
        Log::error($message, [
            'data' => $errors,
            'code' => $code,
        ]);
        return response()->json([
           'status' => $status,
           'message' => $message,
           'errors' => $errors,
        ], $code);
   }
}
