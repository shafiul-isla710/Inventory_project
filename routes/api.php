<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\JwtTokenMiddleware;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\LoginLogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::post('/register',[RegistrationController::class,'registration']);
Route::post('/login',[LoginLogoutController::class,'login']);
Route::post('/reset-password/sent-otp',[ResetPasswordController::class,'sentOtp']);
Route::post('/verify-otp',[ResetPasswordController::class,'verifyOtp']);
Route::post('/reset-password',[ResetPasswordController::class,'resetPassword']);


//After Login
Route::middleware(JwtTokenMiddleware::class)->group(function (){

    Route::get('/user-profile',[ProfileController::class,'userProfile']);
    Route::put('/profile-update',[ProfileController::class,'profileUpdate']);
    Route::get('/logout',[LoginLogoutController::class,'logout']);

    //product
    Route::get('/products',[ProductController::class,'index']);
    Route::get('/product-show/{product}',[ProductController::class,'show']);
    Route::post('/product-store',[ProductController::class,'store']);
    Route::put('/product-update/{product}',[ProductController::class,'update']);

});

Route::group(['prefix'=>'invoice'],function(){

    Route::post('/store',[InvoiceController::class,'store']);
    Route::get('/show/{invoice}',[InvoiceController::class,'show']);
    Route::get('/show/invoice-details/{invoice}',[InvoiceController::class,'show']);
    Route::get('/show/pdf/{invoice}',[InvoiceController::class,'print']);
    
})->middleware(JwtTokenMiddleware::class);



