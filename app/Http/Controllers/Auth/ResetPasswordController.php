<?php

namespace App\Http\Controllers\Auth;

use App\Models\Otp;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\SentOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    use ApiResponse;
    public function sentOtp(SentOtpRequest $request){
        try{
            $data = $request->validated();
            $otp = mt_rand(100000,999999);
            Otp::create([
                'email'=>$data['email'],
                'otp'=>$otp
            ]);
            Mail::to($data['email'])->send(new OTPMail($otp));
            return $this->responseWithSuccess('OTP sent successfully', 200);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }

    public function verifyOtp(VerifyOtpRequest $request){
        try{
            Otp::where(['email'=>$request->email,'otp'=>$request->otp])
                    ->update([
                        'status'=>true
                    ]);
                    
            $exp = time() + (60 * 30);
            $token = JWTToken::generateToken(['email'=>$request->email],$exp);
            return $this->responseWithSuccess('OTP verified successfully', 200)->cookie('reset_password_token', $token['token'], $exp);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try{
            $cookie = $request->cookie('reset_password_token');

            if(!$cookie){
                return $this->responseWithError('Unauthorized', [], 401);
            }

            $data = $request->validated();
            $decoded = JWTToken::verifyToken($cookie);

            $user = User::whereEmail($decoded['payload']->email)->first();
            $user->password = $data['password'];
            $user->save();

            return $this->responseWithSuccess('Password reset successfully', 200)->withoutCookie('reset_password_token');
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }
}
