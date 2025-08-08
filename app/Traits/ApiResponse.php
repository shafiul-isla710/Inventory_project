<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ApiResponse
{
     public function responseWithSuccess($message='Success',$data=[],$code=200):JsonResponse
   {
        return response()->json([
           'status' => true,
           'message' => $message,
           'data' => $data,
        ], $code);
   }
    public function responseWithError($message='Failed',$data=[],$code=400):JsonResponse
   {
        Log::error($message, [
            'data' => $data,
            'code' => $code,
        ]);

        return response()->json([
           'status' => false,
           'message' => $message,
           'data' => $data,
        ], $code);
   }
}
