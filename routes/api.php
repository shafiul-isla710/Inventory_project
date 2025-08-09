<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::post('/register',[AuthController::class,'registration']);
Route::post('/reset-password/sent-otp',[ResetPasswordController::class,'sentOtp']);
Route::post('/verify-otp',[ResetPasswordController::class,'verifyOtp']);
Route::post('/reset-password',[ResetPasswordController::class,'resetPassword']);
Route::post('/login',[LoginController::class,'login']);
Route::post('/logout',[LoginController::class,'logout']);
