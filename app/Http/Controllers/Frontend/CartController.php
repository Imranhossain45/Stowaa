<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts=Cart::where('user_id',auth()->user()->id)->get();
        
        $shippingcharges=ShippingCharge::all();
        return view('frontend.cart.index',compact('carts', 'shippingcharges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "inventory_id"=>"required|integer",
            "quantity"=>"required|integer",
            "sub_total"=>"required|numeric",
        ]);
        
        $success=Cart::create([
            "user_id"=>auth()->user()->id,
            "inventory_id" => $request->inventory_id,
            "cart_quantity" => $request->quantity,
            "sub_total" => $request->sub_total,  
        ]);
        if($success){
            return redirect(route('frontend.cart.index'))->with('success', 'Cart Added Successful!');
        }else{
            return back()->with('error', 'Cart Added Failed!'); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cart=Cart::where('inventory_id',$request->inventory_id)->where('id',$request->cart_id)->where('user_id', auth()->user()->id)->first();
        
        $cart->update([
            "cart_quantity"=>$request->quantity,
            "sub_total"=>$request->quantity * $request->base_price,
            
        ]);
        /* $quan= $cart->cart_quantity; */
        $subTotal=$cart->sum('sub_total');
        return response()->json($subTotal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', "Cart Delete Successfull!");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function checkoutView()
    {
        $carts = Cart::with('inventory')->where('user_id', auth()->user()->id)->get();   
        return view('frontend.cart.checkout',compact('carts'));
    }
}