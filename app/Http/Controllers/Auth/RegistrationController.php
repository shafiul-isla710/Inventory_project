<?php

namespace App\Http\Controllers\Auth;

use App\Mail\OTPMail;
use App\Models\Otp;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    use ApiResponse;

    public function registration(RegistrationRequest $request){
        try{
            $data = $request->validated();

            $userData = Arr::only($data, ['name', 'email', 'password']);
            $profileData = Arr::only($data, ['phone', 'address']);

            $user = User::create($userData);

            $profileData['user_id'] = $user->id;

            if($request->hasFile('avatar')){
                $path = $request->file('avatar')->store('avatars', 'public');
                $profileData['avatar'] = $path;
            }
            Profile::create($profileData);

            return $this->responseWithSuccess('Registration successful',$data=$user, 201);
        }
        catch(\Exception $e){
            return $this->responseWithError('Registration failed. Please try again.', [], 500);
        }
    }

}
