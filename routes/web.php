<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\JwtTokenMiddleware;
use App\Http\Controllers\web\PageController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryController1;
use App\Http\Controllers\Auth\LoginLogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dependencies', function (Category $category) {
    dd($category);
});


Route::group(['prefix'=>'backend'],function(){

    Route::post('/register',[RegistrationController::class,'registration']);
    Route::post('/login',[LoginLogoutController::class,'login']);
    Route::post('/reset-password/sent-otp',[ResetPasswordController::class,'sentOtp']);
    Route::post('/verify-otp',[ResetPasswordController::class,'verifyOtp']);
    Route::post('/reset-password',[ResetPasswordController::class,'resetPassword']);

    //After Login
    Route::middleware(JwtTokenMiddleware::class)->group(function (){

        Route::get('/user-profile',[ProfileController::class,'userProfile']);
        Route::post('/profile-update',[ProfileController::class,'profileUpdate']);
        Route::get('/logout',[LoginLogoutController::class,'logout']);

        //product
        Route::get('/products',[ProductController::class,'index']);
        Route::get('/product-show/{product}',[ProductController::class,'show']);
        Route::post('/product-store',[ProductController::class,'store']);
        Route::put('/product-update/{product}',[ProductController::class,'update'])->name('admin.products.update');

    });

    Route::group(['prefix'=>'admin/products'],function(){
        Route::get('/list',[ProductController::class,'adminProductList'])->name('admin.products.list');
        Route::get('/show/{product}',[ProductController::class,'adminProductEdit'])->name('admin.products.edit');
        Route::post('/store',[ProductController::class,'store']);
        Route::put('/update/{product}',[ProductController::class,'update']);
    })->middleware(JwtTokenMiddleware::class);

    Route::group(['prefix'=>'admin/categories'],function(){
        Route::resource('category',CategoryController1::class);
    })->middleware(JwtTokenMiddleware::class);

    Route::group(['prefix'=>'invoice'],function(){

        Route::post('/store',[InvoiceController::class,'store']);
        Route::get('/show/{invoice}',[InvoiceController::class,'show'])->name('admin.invoice.show');
        Route::get('/show/invoice-details/{invoice}',[InvoiceController::class,'show']);
        Route::get('/show/pdf/{invoice}',[InvoiceController::class,'print']);
        
    })->middleware(JwtTokenMiddleware::class);

});

//frontend Page route start

Route::get('/',[PageController::class,'index']);
Route::get('/login',[PageController::class,'login'])->name('login.page');
Route::get('/register',[PageController::class,'register'])->name('register.page');
Route::get('/sent-otp',[PageController::class,'sentOtp'])->name('forgot-password.send-otp.page');
Route::get('/verify-otp',[PageController::class,'verifyOtp'])->name('verify-otp.page');
Route::get('/reset-password',[PageController::class,'resetPassword'])->name('reset-password.page');

Route::middleware(JwtTokenMiddleware::class)->group(function (){
    Route::get('/dashboard',[PageController::class,'dashboard'])->name('dashboard.page');
    Route::get('/profile',[PageController::class,'profile'])->name('profile.page');

    Route::get('/customer/products', [ProductController::class, 'customerProductList'])->name('customer.products');
    Route::post('/customer/products/order', [OrderController::class, 'customerOrderStore'])->name('customer.product.store');
    Route::get('/customer/products/order/list', [OrderController::class, 'customerOrderList'])->name('customer.product.list');
    
    // order for admin panel
    Route::get('/admin/orders', [OrderController::class, 'adminOrderList'])->name('admin.orders.list');
});

