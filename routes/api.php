<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\JwtTokenMiddleware;
use App\Http\Controllers\Auth\LoginLogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::post('/register',[RegistrationController::class,'registration']);
Route::post('/login',[LoginLogoutController::class,'login']);
Route::post('/reset-password/sent-otp',[ResetPasswordController::class,'sentOtp']);
Route::post('/verify-otp',[ResetPasswordController::class,'verifyOtp']);
Route::post('/reset-password',[ResetPasswordController::class,'resetPassword']);


//After Login
Route::get('/user-profile',[ProfileController::class,'userProfile'])->middleware(JwtTokenMiddleware::class);
Route::put('/profile-update',[ProfileController::class,'profileUpdate'])->middleware(JwtTokenMiddleware::class);
Route::get('/logout',[LoginLogoutController::class,'logout'])->middleware(JwtTokenMiddleware::class);


