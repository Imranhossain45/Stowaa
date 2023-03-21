<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(){
        return view('userdashboard.index');
    }
    public function order(){
        return view('userdashboard.order');
    }
}
