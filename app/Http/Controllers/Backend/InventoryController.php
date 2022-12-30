<?php

namespace App\Http\Controllers\Backend;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {   
        $product=Product::findOrFail($id);
        $sizes=Size::all();
        $colors= Color::all();

        $inventories=Inventory::where('product_id',$id)->get();
        return view('backend.inventory.index',compact('product', 'sizes', 'colors', 'inventories'));
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
            'product_id'=>'required',
            'size'=> 'required',
            'color'=>'required',
            'quantity'=>'required|integer',
            'add_price'=>'nullable|numeric',
        ]);
        Inventory::create([
            'product_id' => $request->product_id,
            'size_id' => $request->size,
            'color_id' => $request->color,
            'quantity' => $request->quantity,
            'additional_price' =>$request->add_price ,
        ]);
        return back()->with('success', 'Inventory add Successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}