<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    
    public function index(){
        return view('pages.home');
    }
    public function login(){
        return view('pages.auth.login');
    }

    public function register(){
        return view('pages.auth.register');
    }
    
    public function sentOtp(){
        return view('pages.auth.send-otp-page');
    }
    public function verifyOtp(){
        return view('pages.auth.verify-otp-page');
    }
    public function resetPassword(){
        return view('pages.auth.reset-pass-page');
    }
    public function dashboard(){
        return view('pages.dashboard.dashboard-page');
    }

    public function profile(Request $request){
        return view('pages.dashboard.profile-page');
    }
}
