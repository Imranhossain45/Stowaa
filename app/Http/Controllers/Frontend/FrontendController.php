<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class FrontendController extends Controller
{
    public function frontendIndex(){
        return view('frontend.index');
    }
    public function contact(){
        return view('frontend.contact');
    }
    public function about(){
        return view('frontend.about');
    }
    public function team(){
        return view('frontend.team');
    }
    public function shopgrid(){
        return view('frontend.shop.shopgrid');
    }
    public function shoplist(){
        return view('frontend.shop.shoplist');
    }
    public function shopdetails(){
        return view('frontend.shop.shopdetails');
    }
}