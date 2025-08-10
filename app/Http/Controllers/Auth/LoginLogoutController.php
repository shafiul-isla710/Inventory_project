<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helper\JWTToken;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;

class LoginLogoutController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        try{
            $user = User::whereEmail($request->email)->first();
            if(!Hash::check($request->password, $user->password)){
                return $this->responseWithError('Invalid email or password', [], 401);
            }
            $userData = [
                'email'=>$user->email,
                'id'=>$user->id,
                'name'=>$user->name,
                'role'=>$user->role,
                'avatar'=>$user->profile->AvatarUrl

            ];
            $ext = time() + (3600 * 24);
            $token = JWTToken::generateToken($userData,$ext);
            return $this->responseWithSuccess('Login successfully',$userData, 200)->cookie('Login_token', $token['token'], $ext);

        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }

    public function logout(Request $request){
        try{
            return $this->responseWithSuccess('Logout successfully', 200)->withoutCookie('Login_token');
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }
    
    
}
