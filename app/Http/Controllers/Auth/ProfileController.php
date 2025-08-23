<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Traits\ApiResponse;
use Illuminate\Support\Arr;
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
            return $this->responseWithSuccess(true,'User profile', new UserResource($user), 200);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError(false,'Something went wrong. Please try again.', [], 500);
        }
    }

    // public function profileUpdate(ProfileUpdateRequest $request)
    // {
    //     try{
    //         $user =Auth::user();
    //         $data = $request->validated();
    //         $name = $request->input('name');

    //         if($request->hasFile('avatar')){

    //            if($user->profile->avatar){
    //                Storage::disk('public')->delete($user->profile->avatar);
    //            }

    //            $path = $request->file('avatar')->store('avatars', 'public');
    //            $data['avatar'] = $path;

    //         }
    //         if($name){
    //             $user->name = $name;     
    //         }
    //         $user->save();
    //         Profile::where('user_id', $user->id)->update($data);
    //         $updateUser = User::get();
    //         return $this->responseWithSuccess(true,'Profile updated successfully', new UserResource($updateUser), 200);
    //     }
    //     catch(\Exception $e){
    //         Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
    //         return $this->responseWithError(false,'Something went wrong. Please try again.', [], 500);
    //     }

    // }
    
    
    public function profileUpdate(ProfileUpdateRequest $request)
    {
        try{
            $user = Auth::user();
            $validate = $request->validated();

            $userData = Arr::only($validate, ['email', 'name']);
            $profileData = Arr::only($validate, ['phone', 'address']);
            $user->update($userData);

            // if profile image:

            if($request->hasFile('avatar')){
                $path  = $request->file('avatar')->store('avaters', 'public');
                $profileData['avatar'] = $path;
            }

            $user->profile()->update($profileData);


            return response([
                'status' => true,
                'message' => 'Profile Updated Successfully',
                'data' => new UserResource($user)
            ]);
        }catch (\Exception $e){
            Log::critical($e->getMessage() . ' ' .  $e->getFile() . ' ' . $e->getLine());
            return response([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
    

    }
}
