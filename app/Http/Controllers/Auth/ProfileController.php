<?php

namespace App\Http\Controllers\Auth;

use App\Models\Profile;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\ProfileUpdateRequest;


class ProfileController extends Controller
{
    use ApiResponse;

    public function userProfile(Request $request)
    {
        try{
            $user =Auth::user();
            return $this->responseWithSuccess('User profile', new UserResource($user), 200);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        try{
            $user =Auth::user();
            $data = $request->validated();

            if($request->hasFile('avatar')){

               if($user->profile->avatar){
                   Storage::disk('public')->delete($user->profile->avatar);
               }

               $path = $request->file('avatar')->store('avatars', 'public');
               $data['avatar'] = $path;

            }
            Profile::where('user_id', $user->id)->update($data);
            return $this->responseWithSuccess('Profile updated successfully', [], 200);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }

    }
}
