<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    public function index(){
        return view('userdashboard.index');
    }
    public function order(){
        return view('userdashboard.order');
    }
    public function invoice($id){
        $order = Order::with('invoice')->find($id);
        //return Storage::download('invoice/'. $order->invoice->invoice);
        return response()->download(public_path('storage/invoice/'). $order->invoice->invoice);
    }
}
