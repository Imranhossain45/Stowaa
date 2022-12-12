<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function login(){
    return view('userauth.userauth'); 
    }
    public function registration(){
    return view('userauth.userauth'); 
    }
}