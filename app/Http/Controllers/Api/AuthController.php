<?php

namespace App\Http\Controllers\Api;

use App\Mail\OTPMail;
use App\Models\Otp;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponse;

    public function registration(RegistrationRequest $request){
        try{
            $data = $request->validated();
            User::create($data);

            return $this->responseWithSuccess('Registration successful', 201);
        }
        catch(\Exception $e){
            return $this->responseWithError('Registration failed. Please try again.', [], 500);
        }

    }

}
